<?php
/**
 * Created by PhpStorm.
 * User: silsuer
 * Date: 2018/2/4
 * Time: 11:25
 */

namespace App\Http\Plugins\MenuManager;

// 菜单管理插件
use App\Http\Plugins\BasePlugins;

class MenuManager extends BasePlugins
{
    public $info = [
        'name' => '菜单管理',
        'dir' => 'MenuManager',
        'description' => '菜单管理插件，用于对后台菜单进行增删改查排序等操作'
    ];

    public $template_map = [
       'index' => [
           'name'=> '菜单管理',
           'template' => 'index.html'
       ] ,
        'add' => [
            'name' => '菜单添加',
            'template' => 'add.html'
        ]
    ] ;
}