<?php
/**
 * Created by PhpStorm.
 * User: liuho
 * Date: 2018/2/12
 * Time: 17:35
 */

namespace App\Http\Plugins\PluginsManager;


use App\Http\Plugins\BasePlugins;

class PluginsManager extends BasePlugins
{
    public $info = [
        'name' => '插件管理',
        'dir' => 'PluginsManager',
        'description' => '插件管理插件，用于对后台菜单进行增删改查排序等操作'
    ];

    public $template_map = [
        'index' => [
            'name'=> '插件管理',
            'template' => 'index.html'
        ]
    ] ;
}