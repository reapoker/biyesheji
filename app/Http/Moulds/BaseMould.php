<?php
/**
 * Created by PhpStorm.
 * 基础模型类
 * User: silsuer
 * Date: 2018/1/9
 * Time: 18:03
 */

namespace App\Http\Moulds;


use App\Libraries\Component;
use App\Model\Mould;
use Illuminate\Database\Schema\Blueprint;
use Mockery\Exception;

class BaseMould
{

    public $config = [] ; //必须定义，用来生成配置表中的默认配置项

    // 要存入模型表的数据 name,name_dir,description
    public $info = [] ;

    public $template_map = array(); // 模型配置表中的一个字段，配置模版映射

    // 构造函数，用来初始化所有列
    public function __construct()
    {
        $data=[]; // 用来临时记录config值
        foreach ($this->config as $v){
            $data[$v] = json_encode($this->{$v});
        }
        $this->config = $data; // 重新赋值给config ，此时config是一个数组，键是名字，值是json串
    }

    // 首先在模型表中插入该模型，然后返回id
    // 生成模型配置表
    // 将组件存入数据库
    public function install(){
        if(!Mould::where('dir',$this->info['dir'])->get()->isEmpty()){
            throw new \Exception("该模型已安装");
        }

        //首先插入已安装模型数据库
        $mould = new Mould();
        $mould->name =$this->info['name'];
        $mould->dir = $this->info['dir'];
        $mould->description = $this->info['description'];
        $mould->template_map = json_encode($this->template_map);
        $mould->config = json_encode($this->config);
        $mould->save();

        // 组件放在模型文件夹的Components文件夹中，自定义组件放在Http/Components中
        // 组件不必存入数据库，但是要把组件中的js文件放入public/js/components中
        // 把组件中的js文件复制到/public/js/components
//        move_to_components($this->info['dir']);
        // 创建json映射文件
//        Mould::createJson();
        // 渲染所有组件即可
        $x = new Component();
        $x->renderComponentsJson();
        // 安装完成
        return true;
    }

    public function uninstall(){
        // 干掉模型数据库中的数据即可

        if(Mould::where('dir',$this->info['dir'])->get()->isEmpty()){
            throw new \Exception("数据库中不存在此模型");
        }else{
            Mould::where('dir',$this->info['dir'])->delete(); //删除
        }
        return true;
    }

    public function handle($arr){
        // 从参数中获取组件名等信息,
        // 然后去组件目录下引入该组件,
        // 然后调用该组件下的函数,
        // 并返回结果
    }

    public function getSettingTemp(){
        // 这里返回的模版映射，只会在已安装模型列表中出现
        $arr = [];
        foreach ($this->template_map as $k => $v){
            if(array_key_exists('show',$v) && in_array('setting',$v['show'])){
                $arr[$k] = $v;
            }
        }
        return $arr;
    }

    public function getModuleTemp(){
        // 这里返回的模版映射，只会在模块列表的更多操作中出现
        $arr = [];
        foreach ($this->template_map as $k => $v){
            if(array_key_exists('show',$v) && in_array('module',$v['show'])){
                $arr[$k] = $v;
            }
        }
        return $arr;
    }
}