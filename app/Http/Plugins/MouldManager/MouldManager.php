<?php
/**
 * Created by PhpStorm.
 * User: liuho
 * Date: 2018/2/12
 * Time: 20:35
 */

namespace App\Http\Plugins\MouldManager;


use App\Http\Plugins\BasePlugins;

class MouldManager extends BasePlugins
{

    public $info = [
        'name' => '模型管理',
        'dir' => 'MouldManager',
        'description' => '模型管理插件，管理所有模型'
    ];

    public $template_map = [
        'index' => [
            'name'=> '模型管理',
            'template' => 'index.html'
        ],
        'installed' => [
            'name' => '已安装模型',
            'template' => 'installed.html',
        ],
    ];
}