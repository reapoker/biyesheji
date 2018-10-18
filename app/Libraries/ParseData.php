<?php

namespace App\Libraries;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

/**
 * Created by PhpStorm.
 * 用来解析redis或者数据库的模型或模块字段等,解析为Laravel建表语句或对表字段的增删改及对比验证
 * User: silsuer
 * Date: 18/1/10
 * Time: 下午1:52
 */
class ParseData
{

    // 对传入的json字符串转成php数组,然后对自定义的验证标签进行解析

    /*
     * 暂时解析模型支持识别列：int string text mediumText increments
     */


    // 对传入的数据生成成mysql数据表
    /**
     * @param $table_name
     * @param $cols
     */
    public function createTable($table_name, $cols)
    {
        if (is_string($cols)) {
            $cols = json_decode($cols);
        }
        $config = [];
        if (is_array($cols) || is_object($cols)) {
            foreach ($cols as $k => $v) {
                if ($k == "" || $v == "") continue;
                $config[trim($k)] = $this->toArray(json_decode(trim($v)));
            }
        }
        $cols = $config;
        if (!array_key_exists('id', $cols)) {  //如果没有id这个键名的话，加入这个键，并设为主键自增
            $a = [];
            $a['id'] = ['name' => 'id', 'dir' => 'id', 'type' => 'increments'];
            foreach ($cols as $k => $v) {
                $a[$k] = $v;
            }
            $cols = $a;
        }
        if (Schema::hasTable($table_name)) {
            throw new \Exception($table_name . "已存在，请检查设置！");
        }
        Schema::create($table_name, function (Blueprint $table) use ($cols) {
            foreach ($cols as $k => $v) {
                if ($type = $this->hasType($v)) {
                    if ($default = $this->hasDefault($v)) {
                        if ($comment = $this->hasComment($v)) {
                            if ($type == "increments") {
                                $table->{$type}($k)->default($default)->comment($comment);
                            } else {
                                $table->{$type}($k)->default($default)->nullable()->comment($comment);
                            }
                        } else {
                            if ($type == "increments") {
                                $table->{$type}($k)->default($default);
                            } else {
                                $table->{$type}($k)->default($default)->nullable();
                            }
                        }
                    } else {
                        if ($type == "increments") {
                            $table->{$type}($k);
                        } else {
                            $table->{$type}($k)->nullable();
                        }
                    }
                }
            }
            $table->timestamps();
        });
        return true;
    }

    // 根据传入的配置，更改表结构  用于模块修改
    public function syncTable($old_table,$old_config ,$new_table,$new_config)
    {

        // 这里传入的cols 包括了新表名，$cols['config']才是最终表结构，此处跟createTable不一样
        if($old_table!= $new_table){
            // 新旧表名不一样，需要更改表名
            Schema::rename($old_table,$new_table);
        }

        // 接下来的操作全部在新表上使用
        $new_cols = [];
        foreach (json_decode($new_config,true) as $k=>$v){
            if($k==""||$v=="") continue;
            $new_cols[trim($k)] = json_decode($v,true);
        }
        $old_cols = [];
        foreach (json_decode($old_config,true) as $k=>$v){
            if($k==""||$v=="") continue;
            $old_cols[trim($k)] = json_decode($v,true);
        }

        // 有的时候老旧的config和真实数据表中的不一致，此时把旧config中多余的字段干掉
         $columns = Schema::getColumnListing($new_table);
         foreach ($columns as $k=>$v){
             if($v=='updated_at'||$v=='id'||$v=='created_at') unset($columns[$k]);
         }
         foreach ($old_cols as $k=>$v){
             if(!in_array($k,$columns)) unset($old_cols[$k]);
         }


        // 将列数据都整理成了数组格式，接下来开始对比
        // 得到删掉了哪些列，添加了哪些列，修改了哪些列， 列是无法重命名的，重命名的列是先删掉再增加，数据将丢失
        $delete_cols = []; // 用来记录要删除的列
        $add_cols = []; // 用来记录要添加的列
        $change_cols = []; // 用来记录要更改的列：dir不可更改 comment default 可以更改
        foreach ($old_cols as $k=>$v){
            // 删除的列就是旧表里有，新表里没有
            if(!array_key_exists($k,$new_cols)) $delete_cols[$k] = $v;
        }

        foreach ($new_cols as $k=>$v){
            // 添加的列就是新表里有，旧表里没有
            if(!array_key_exists($k,$old_cols)){
                $add_cols[$k] = $v;
            } else{
                // 存在的话，与旧列对比，把修改过的添加到change_cols中
                if($v != $old_cols[$k]) {
                        $change_cols[$k] = $v;
                }
                // 对于数据库来说，对于列，只有dir,type,comment,default四种，name如果更改，相当于删除列再添加列，不再此处范围内
                // 所以只有type comment default 三种进行判断
            }
        }
        // 开始删除列
        Schema::table($new_table, function ($table) use ($delete_cols) {
            foreach ($delete_cols as $k=>$v){
                $table->dropColumn($k);
            }
        });
        // 开始添加列
        Schema::table($new_table,function ($table) use ($add_cols) {
            foreach ($add_cols as $k=>$v){
                if ($type = $this->hasType($v)) {
                    if ($default = $this->hasDefault($v)) {
                        if ($comment = $this->hasComment($v)) {
                            if ($type == "increments") {
                                $table->{$type}($k)->default($default)->comment($comment);
                            } else {
                                $table->{$type}($k)->default($default)->nullable()->comment($comment);
                            }
                        } else {
                            if ($type == "increments") {
                                $table->{$type}($k)->default($default);
                            } else {
                                $table->{$type}($k)->default($default)->nullable();
                            }
                        }
                    } else {
                        if ($type == "increments") {
                            $table->{$type}($k);
                        } else {
                            $table->{$type}($k)->nullable();
                        }
                    }
                }
            }
        });

        // 对比新列与旧列 不相同的话，执行一个函数
        foreach ($change_cols as $k=>$v){
            if($this->hasDefault($v)){
                if($v['default']!=$old_cols[$k]['default']){
                    Schema::table($new_table,function($table) use ($v) {
                        $table->{$v['type']}($v['dir'])->default($v['default'])->change();
                    });
                }
            }


            if($this->hasType($v)){
                if($v['type']!=$old_cols[$k]['type']){
                    throw new \Exception("字段类型暂时不提供更改！");
                }
            }


            if($this->hasComment($v)){
                if($v['comment']!=$old_cols[$k]['comment']){
                    Schema::table($new_table,function($table) use ($v) {
                        $table->{$v['type']}($v['dir'])->comment($v['comment'])->change();
                    });
                }
            }


        }

      return true;


    }


    public function hasType($value)
    {
        if (array_key_exists('type', $value)) {
            return $value['type'];
        }
        return false;
    }

    // 判断是否字符串中存在default项，如果存在，返回default的值，如果不存在，返回false
    public function hasDefault($value)
    {
        if (array_key_exists('default', $value)) {
            return $value['default'];
        }
        return false;
    }

    public function hasComment($value)
    {
        if (array_key_exists('comment', $value)) {
            return $value['comment'];
        }
        return false;
    }

    /**
     * 数组 转 对象
     *
     * @param array $arr 数组
     * @return object
     */
    function array_to_object($arr)
    {
        if (gettype($arr) != 'array') {
            return;
        }
        foreach ($arr as $k => $v) {
            if (gettype($v) == 'array' || getType($v) == 'object') {
                $arr[$k] = (object)array_to_object($v);
            }
        }

        return (object)$arr;
    }

    /**
     * 对象 转 数组
     *
     * @param object $obj 对象
     * @return array
     */
    function toArray($obj)
    {
        $obj = (array)$obj;
        foreach ($obj as $k => $v) {
            if (gettype($v) == 'resource') {
                return;
            }
            if (gettype($v) == 'object' || gettype($v) == 'array') {
                $obj[$k] = (array)$this->toArray($v);
            }
        }

        return $obj;
    }
}