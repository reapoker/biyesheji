<?php
/**
 * Created by PhpStorm.
 * User: liuho
 * Date: 2018/2/20
 * Time: 11:03
 */

namespace App\Http\Plugins\WebIM;


use App\Http\Plugins\BasePlugins;
use GatewayClient\Gateway;

class WebIM extends BasePlugins
{
    public $info = [
        'name' => '客服聊天',
        'dir' => 'WebIM',
        'description' => '客服聊天插件，用于后台管理员之间或者会员间对话'
    ];

    public $template_map = [
        'index'=>[
            'name'=>'设置',
            'template'=>'index.html'
        ],
        'box' => [
            'name'=> '聊天',
            'template' => 'box.html'
        ] ,
    ] ;

    /* 在install函数中应该添加菜单选项
     * 并且新建一个用户表
     * 新建一个群组表
     * 表中定义所有的额外数据
     * 并且导入当前用户表中的所有用户
     */


    public function bind($client_id){
        $uid = \Auth::id();
        session(['client_id'=>$client_id]);
        Gateway::$registerAddress = "192.168.191.1:1238";
        Gateway::bindUid($client_id,$uid);
        return true;
    }

    public function sendToAll($content){
        Gateway::$registerAddress = "192.168.191.1:1238";
        Gateway::sendToAll($content);
    }

}