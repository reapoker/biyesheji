<?php
namespace App\Http\Moulds\Classification;
use App\Http\Moulds\BaseMould;

/**
 * Created by PhpStorm.
 * User: liuho
 * Date: 2018/2/27
 * Time: 13:17
 */

class Classification extends BaseMould
{
    public $info = [
        'name' => '分类模型', // 名称
        'dir' => 'Classification', // 唯一英文名，不可以重复
        'description' => '分类模型，为其余所有模型以及插件提供分类服务',//以上三项为必填项，下方为选填项
        'author' => 'silsuer',
        'logo' => 'logo.jpg',
    ];

    public $template_map = [
        'index' => [
            'name'=> '分类列表',
            'template' => 'list.html',
            'show' => ['module'],
        ],
        'add' => [
            'name' => '添加分类',
            'template'=>'add_classification.html'
        ],
        'modify'=>[
            'name' => '修改分类',
            'template'=> 'modify_classification.html'
        ]
    ];

    // 定义分类默认字段 分类名，上级分类id 分类介绍
    public $config = ["name","pid","subject"];
    public $name = [
        'name' => '分类名',
        'dir' => 'name',
        'comment'=> '分类名',
        'type' => 'string',
        'view'=>'input',
        'show'=>1
    ];

    public $pid = [
        'name'=> '上级分类id',
        'dir'=>'pid',
        'comment'=>'上级分类id',
        'type'=>'integer',
        'default'=>0,
        'view'=>'select',
        'show'=>1
    ];


    public $subject = [
        'name'=> '分类简介',
        'dir'=>'subject',
        'comment'=>'分类简介',
        'type'=>'text',
        'view'=>'textarea',
        'show'=>1
    ];
}