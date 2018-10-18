<?php
/**
 * Created by PhpStorm.
 * User: liuho
 * Date: 2018/2/4
 * Time: 11:26
 */

namespace App\Http\Plugins;


// 基础插件类，所有插件都继承这个类
use App\Model\Plugin;

class BasePlugins
{

    public $info = [] ;   // 用来记录插件信息

    public $template_map = array(); // 用来记录模版映射

    // 构造函数，用来初始化
    public function __construct(){
        $this->info['tempalte_map'] = $this->template_map;
    }

    // 插件安装
    public function install(){
        if(!Plugin::where('dir',$this->info['dir'])->get()->isEmpty()){
            throw new \Exception("存在同名插件，请检查！");
        }
        $plugin = new Plugin();
        $plugin->name = $this->info['name'];
        $plugin->dir = $this->info['dir'];
        $plugin->description = $this->info['description'];
        $plugin->save();
        return true;  // 安装成功
    }

   // 插件卸载
    public function uninstall(){

    }
}