<?php
/**
 * Created by PhpStorm.
 * User: liuho
 * Date: 2018/2/7
 * Time: 10:21
 */

namespace App\Http\Plugins\AdminManager;


use App\Http\Plugins\BasePlugins;

class AdminManager extends BasePlugins
{
    public $info = [
        'name' => '后台管理',
        'dir' => 'AdminManager',
        'description' => '后台管理插件，用来显示后台页面'
    ];

    public $template_map = [
        'index' => [
            'name'=> '后台管理',
            'template' => 'index.html'
        ],
        'login' => [
            'name' => '后台登录页',
            'template' => 'login.html'
        ]
    ];


}