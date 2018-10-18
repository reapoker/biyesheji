<?php
/**
 * Created by PhpStorm.
 * User: silsuer
 * Date: 2018/3/16
 * Time: 19:53
 */

namespace App\Libraries;


use Illuminate\Http\File;

class Upload
{
    // 定制的文件上传类
    public $file; // 资源类型

    public $config; // 配置项

    public $save_path; // 配置项中的存储位置

    public $ext = [];  // 允许得扩展名

    public $real_ext; // 真实扩展名

    public $rand;   // 命名规则



    public function __construct($file,$config)
    {
        $this->file = $file; //初始化
        $cols = json_decode($config,true);
        $c = [];
        foreach ($cols as $k=>$v){
            if($k==""||$v=="") continue;
            $c[trim($k)] = json_decode($v,true);
        }
        $this->config = $c;
    }


    // 验证
    public function validate($dir){
        // 寻找到是上传文件的字段，得到
        if(array_key_exists($dir,$this->config)){

            $c = $this->config[$dir]; // 获取到这个字段的配置
            if(strpos($c['view'],'upload')){ // 判断包含字符串
                // 可以确认，上传，开始解析  $c['view']=multi_img_upload->/Storage/Upload/;jpg|png;random_timestamp
                $carr = explode('->',$c['view']);
                if(count($carr)==2){
                    $arr = explode(';',$carr[1]);
                    $this->save_path = rtrim(app()->basePath(),'/') .  $arr[0] ;  // 存储路径
                    $this->ext = explode('|',$arr[1]); // 扩展名
                    $this->rand = $arr[2];  // 加密方式

                    // 此处判断有没有目录，如果没有，创建目录
                    if(!is_dir($this->save_path)){
                        mkdir($this->save_path, 0777, true);
                    }
                    // 此处判断扩展名
                    $this->real_ext = $this->file->getClientOriginalExtension();
                    if(in_array($this->real_ext,$this->ext)){
                        return true;  // 扩展名验证通过
                    }

                }
            }
        }
    }

    public function move(){
        // 把数据移动到要保存的文件夹
        // 1. 根据选择的文件名生成方式，生成一个不重复的文件名
        //     三种文件名生成方式 file_name 原文件名  timestamp 时间戳  random_timestamp 时间戳+8位随机字符串
        // 2. 把文件移动过去
        // 3. 返回最后生成的扩展名以及路径
        $name = '';
        switch ($this->rand){
            case 'file_name':
                $name = $this->file->getClientOriginalName(); // 原始文件名
                break;
            case 'timestamp':
                $name = time();  // 当前时间戳
                break;
            case 'random_timestamp':
                $name = $this->random_str();
                break;
            default:
                throw new \Exception("未定义的文件名生成方式！");
        }

        // 拼接成完整的上传文件的路径名
//        $path = rtrim($this->save_path,'/').'/'.$name .'.'.$this->real_ext;

        // 只需要返回名字即可，保存目录已经在config中了，所以只需要知道名字即可取出
        $last_name = $name . '.' . $this->real_ext;
        $this->file->move($this->save_path,$name.'.'.$this->real_ext);
        return $last_name;
    }

    public function random_str(){
        // 生成一个时间戳+8位随机字符的文件名
        $str = "QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm";
        str_shuffle($str);
        $name = time() . substr(str_shuffle($str), 0, 8);
        // 如果文件存在，那么重新生成，这样可以保证上传的时候不会被覆盖
        if(file_exists(rtrim($this->save_path,'/').'/'.$name)) $name = $this->random_str();
        return $name;
    }

}