<?php
/**
 * Created by PhpStorm.
 * User: liuho
 * Date: 2018/2/12
 * Time: 21:27
 */

namespace App\Http\Plugins\ModulesManager;


use App\Http\Plugins\BasePlugins;

class ModulesManager extends BasePlugins
{
    public $info = [
        'name' => '模块管理',
        'dir' => 'ModulesManager',
        'description' => '模块管理插件，用来操作所有根据模型创建的模块'
    ];

    public $template_map = [
        'index' => [
            'name'=> '模块管理',
            'template' => 'index.html'
        ],
        'recycle_bin' => [
            'name' => '模块回收站',
            'template' => 'recycle_bin.html'
        ],
        'add'=>[
            'name' => '新建模块',
            'template' => 'add.html',
        ],
        'cols_add' => [
            'name' => '添加自定义字段',
            'template' => 'cols_add.html',
        ],
        'cols_modify' => [
            'name' => '修改自定义字段',
            'template' => 'cols_modify.html',
        ],
        'modify' =>[
            'name' => '修改模块',
            'template' => 'modify.html',
        ]
    ];
}