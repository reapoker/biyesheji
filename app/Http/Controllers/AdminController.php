<?php
/**
 * Created by PhpStorm.
 * User: silsuer
 * Date: 2018/3/8
 * Time: 15:42
 */

namespace App\Http\Controllers;
use GatewayClient\Gateway;

class AdminController
{
    public function show($tpl = 'p.AdminManager.login')
    {
       // return app('smarty.view')->display('Plugins/AdminManager/html/index.html');
        $this->display($tpl);
    }

    public function showParam($tpl = 'p.AdminManager.login', $param = 'index')
    {
        $this->display($tpl);
    }

    public function display($template)
    {
        $t = explode('.', $template);
        //$dir; // 对象路径
        if (count($t) != 3) {
            throw new \Exception("模版路径出错！");
        }
        $dir = '';
        switch ($t[0]) {
            case 'm':  // 模型映射
                $dir = '\App\Http\Moulds\\' . $t[1] . '\\' . $t[1];
                $path = 'Moulds/' . $t[1] . '/html/';
                break;
            case 'p': // 插件映射
                $dir = '\App\Http\Plugins\\' . $t[1] . '\\' . $t[1];
                $path = 'Plugins/' . $t[1] . '/html/';
                break;
            default:
                break;
        }
        $obj = new $dir();
        $map = $obj->template_map;
        $path .= $map[$t[2]]['template'];
       return app('smarty.view')->display($path);

    }

    public function asd(){
        // 数据绑定
        Gateway::$registerAddress = '192.168.1.6:1238';
        Gateway::sendToAll("1q111111asdasdads");
//        Gateway::$registerAddress = '192.168.1.6:1238';

    }

}