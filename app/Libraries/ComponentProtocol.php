<?php
/**
 * Created by PhpStorm.
 * User: silsuer
 * Date: 2018/2/1
 * Time: 13:15
 */

namespace App\Libraries;

/*封装组件执行时候的协议，用来读取php文件，并执行这个文件*/
class ComponentProtocol
{
    public function __construct()
    {
        // 判断这个协议是否注册，如果没注册，则将当前类注册进去
        if(!in_array('aceberg',stream_get_wrappers())){
            stream_register_wrapper("aceberg","\App\Libraries\ComponentProtocol");
        }
    }

    private $string;
    private $position;
    public function stream_open($path, $mode, $options, &$opened_path) {
        $url = parse_url($path);
        $name = $url["host"];
        $match = "/function(.*)handle(.*)\(/U";
        //根据ID到数据库中取出php字符串代码,用正则获取到handle的位置，替换成一个不重复的名字，然后引入进来
        $name_arr = explode('.',$name);
        if(count($name_arr)==2){
            $component_name = $name_arr[0];
            $new_name = $name_arr[1];
            $comp = new Component();
            $path = $comp->getPath($component_name);

            if(file_exists($path)){
                $content = file_get_contents($path);
                // 替换字符串
                $a =  preg_replace($match,' function '.$new_name.'(',$content);
                $this->string = $a;
                $this->position = 0;
                return true;
            }
        }else{
            throw new \Exception("aceberg协议参数传递错误".json_encode($name_arr));
        }



    }
    public function stream_read($count) {
        $ret =  substr($this->string, $this->position, $count);
        $this->position += strlen($ret);
        return $ret;
    }
    public function stream_eof() {
    }
    public function stream_stat() {}

    public function getSingleName(){
        // 获取一个不重复的方法名，并返回，等待替换
        $str="QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm";
        str_shuffle($str);
        $name=substr(str_shuffle($str),0,10);
        if(function_exists($name)) $name = $this->getSingleName();
        return $name;
    }


}