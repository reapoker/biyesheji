<?php
namespace App\Http\Moulds\ShoppingCart;
use App\Http\Moulds\BaseMould;

/**
 * Created by PhpStorm.
 * User: liuho
 * Date: 2018/2/27
 * Time: 13:17
 */

class ShoppingCart extends BaseMould
{
    public $info = [
        'name' => '购物车模型', // 名称
        'dir' => 'ShoppingCart', // 唯一英文名，不可以重复
        'description' => '购物车模型，与商品模型关联实现电商项目',//以上三项为必填项，下方为选填项
        'author' => 'silsuer',
        'logo' => 'logo.jpg',
    ];

    public $template_map = [
        'index' => [
            'name'=> '购物车列表',
            'template' => 'list.html',
            'show' => ['module'],
        ],
    ];

    // 定义分类默认字段 购物车内商品模块id 购物车内商品id 所属用户id 时间
    public $config = ["module_id","commodity_id","uid","time"];
    public $module_id = [
        'name' => '商品模块id',
        'dir' => 'module_id',
        'comment'=> '购物车内的商品模块id',
        'type' => 'integer',
        'view'=>'input',
        'show'=>1
    ];

    public $commodity_id = [
        'name'=> '商品id',
        'dir'=>'commodity_id',
        'comment'=>'购物车内的商品id',
        'type'=>'integer',
        'view'=>'input',
        'show'=>1
    ];

    public $uid = [
        'name' => '所属用户id',
        'dir' => 'uid',
        'comment'=> '添加购物车的用户id',
        'type' => 'integer',
        'default'=>0,
        'view'=>'input',
    ];


    public $time = [
        'name'=> '时间',
        'dir'=>'time',
        'comment'=>'加入购物车的时间',
        'type'=>'string',
        'view'=>'timer',
        'show'=>1
    ];
}