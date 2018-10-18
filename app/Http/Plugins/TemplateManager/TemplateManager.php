<?php
/**
 * Created by PhpStorm.
 * User: liuho
 * Date: 2018/2/7
 * Time: 10:40
 */

namespace App\Http\Plugins\TemplateManager;


use App\Http\Plugins\BasePlugins;

class TemplateManager extends BasePlugins
{
    public $path;
    public $tempaltes;
    public $info = [
        'name' => '模版管理',
        'dir' => 'TemplateManager',
        'description' => '模版管理插件，记录组件中需要调用渲染的模版'
    ];

    public $template_map = [
        'index' => [
            'name'=> '模版管理',
            'template' => 'index.html'
        ] ,
        'add' => [
            'name' => '模版添加',
            'template' => 'add.html'
        ],
        'modify'=>[
            'name' => '模版修改',
            'template'=> 'modify.html'
        ]
    ] ;

    public function __construct()
    {
        $this->path = public_path() . '/templates/';
        if($arr = scandir($this->path)){
            $t = [];
            foreach ($arr as $v){
                if($v == '.'||$v=='..') continue;
                $t['name'] = basename($v,'.tpl');
                $p = $this->path . $v;
                if(file_exists($p)){
                    $t['template'] = file_get_contents($p);
                }
                $this->tempaltes[] = $t;
            }

        }
    }

    public function get($name){
        foreach ($this->tempaltes as $v){
            if($v['name'] == $name){
                return $this->toArray($v);
            }else{
                continue;
            }
        }
        return false; // 未找到
    }

    public function delete($name){
        // 从数组里删掉
        foreach ($this->tempaltes as $k => $v){
            if($v['name'] == $name){
                unset($this->tempaltes[$k]);
            }else{
                continue;
            }
        }
        // 从文件夹里删掉
        $p = $this->path . $name . '.tpl';
        $res = unlink($p);  // 删除文件
        return $this->tempaltes;  // 返回删除后的数组
    }

    public function modify($data){
       $r1 =  $this->delete($data['name']); // 删除要修改的文件
       $r2 = $this->register($data);
        return true;
    }

    public function register($data){
        $t = [];
        $t['name'] = $data['name'];
        $t['template'] = $data['template'];
        $this->tempaltes[] = $t;
        // 新建一个文件
        $p = $this->path . $data['name'] . '.tpl';
        $file = fopen($p,'w+'); // 写入
        fwrite($file,$data['template']); // 模版解码后放回
        fclose($file); //关闭句柄
        return $this->tempaltes;
    }



    public function toArray($obj){
        return json_decode(json_encode($obj),true);
    }
}