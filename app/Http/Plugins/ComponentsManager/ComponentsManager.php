<?php
/**
 * Created by PhpStorm.
 * User: liuho
 * Date: 2018/2/12
 * Time: 17:45
 */

namespace App\Http\Plugins\ComponentsManager;


use App\Http\Plugins\BasePlugins;

class ComponentsManager extends BasePlugins
{
    public $info = [
        'name' => '组件管理',
        'dir' => 'ComponentsManager',
        'description' => '组件管理插件，操作网站中的所有组件'
    ];

    public $template_map = [
        'index' => [
            'name'=> '组件管理',
            'template' => 'index.html'
        ] ,
        'add' => [
            'name' => '组件添加',
            'template' => 'add.html'
        ],
        'modify' => [
            'name' => '组件修改',
            'template' => 'modify.html'
        ]
    ] ;
}