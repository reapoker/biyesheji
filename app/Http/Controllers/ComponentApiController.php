<?php
/**
 * Created by PhpStorm.
 * User: liuho
 * Date: 2018/3/9
 * Time: 9:56
 */

namespace App\Http\Controllers;


use App\Libraries\Upload;
use App\Model\ComponentListener;
use App\Model\Module;
use Illuminate\Http\Request;

class ComponentApiController
{

    public function handle(Request $request)
    {
        $res = handleComponent($request['name'], $request->all());
        return $this->statusReturn($res);
    }

    public function webHandle(Request $request){
        // 已经经过中间件处理

        // 执行handle方法
        $res = handleComponent($request['name'],$request);

        // 直接返回数据，会再次经过中间件处理
        return $res;
    }

    public function statusReturn($res)
    {

        /*
         * return "操作成功"
         * return ["操作成功",true]
         * return ["操作成功"， false]
         * return array[]
         * return array[array(),ture/false]
         * return */

        if (is_string($res)) {
            return responseSuccessed(null, $res);
        }

        if (is_array($res) || is_object($res)) {
            $res = $this->all_to_array($res); // 全部转换为数组
            if (count($res) == 2 && array_key_exists(0, $res) && array_key_exists(1, $res)) {
                if (is_string($res[0]) && is_bool($res[1])) {
                    if ($res[1]) {
                        return responseSuccessed(null, $res[0]);
                    } else {
                        return responseFailed(null, $res[0]);
                    }
                } else if (is_array($res[0] && is_bool($res[1]))) {
                    if ($res[1]) {
                        return responseSuccessed($res[0]);
                    } else {
                        return responseFailed($res[0]);
                    }
                }
            }
            if (count($res) == 3 && array_key_exists(0, $res) && array_key_exists(1, $res) && array_key_exists(2, $res) && is_array($res[0]) && is_string($res[1]) && is_bool($res[2])) {
                if ($res[2]) {
                    return responseSuccessed($res[0], $res[1]);
                } else {
                    return responseFailed($res[0], $res[1]);
                }
            }

        }

        if(is_array($res)&&empty($res)){
            return responseSuccessed();
        }


        if ($res) {
            return responseSuccessed($res);
        } else {
            return responseFailed();
        }
    }

    public function all_to_array($obj)
    {
        if (is_object($obj)) {
            $obj = obj_to_array($obj);
        }
        if (is_array($obj)) {
            foreach ($obj as $k => $v) {
                if (is_object($v)) $obj[$k] = $this->all_to_array($obj[$k]);
            }
        }
        return $obj;
    }


    public function upload(Request $request){
        // 文件上传时经过此处,将文件上传成功，然后返回文件路径~  前端把文件路径写到属性中，添加的时候，将文件路径添加到数据库中
        $url = $request->header('Referer'); // 获取上传模块的id
        $arr = explode('/',$url);
        $module_id = end($arr);
        $module = Module::find($module_id); // 获取模块
//        dd($module_id);
        $dir = $request->header('dir'); // 前台传来的字段名，因为一个模块中可能有多个上传字段
        $config = $module->config; // 获取配置
        // 根据配置对上传类型进行验证
        $file = $request->file('file');
        $f = new Upload($file,$config);
        $v =  $f->validate($dir);  // 验证是否符合后缀名等
        if($v){
             $path = $f->move();  // 移动文件
            return $path; // 上传成功！返回文件路径+名
        }else{
            dd("上传失败！请检查扩展名及其他选项！");
        }
        

    }
}