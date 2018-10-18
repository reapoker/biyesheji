<?php
namespace App\Http\Moulds\Commodity;
use App\Http\Moulds\BaseMould;

/**
 * Created by PhpStorm.
 * User: liuho
 * Date: 2018/2/27
 * Time: 13:17
 */

class Commodity extends BaseMould
{
    public $info = [
        'name' => '商品模型', // 名称
        'dir' => 'Commodity', // 唯一英文名，不可以重复
        'description' => '商品模型,提供商品等数据',//以上三项为必填项，下方为选填项
        'author' => 'silsuer',
        'logo' => 'logo.jpg',
    ];

    public $template_map = [
        'index' => [
            'name'=> '商品列表',
            'template' => 'list.html',
            'show' => ['module'],
        ],
        'add' => [
            'name' => '添加商品',
            'template'=>'add_commodity.html'
        ],
        'modify'=>[
            'name' => '修改分类',
            'template'=> 'modify_commodity.html'
        ]
    ];

    // 定义分类默认字段 商品名 价格 价格单位（元、美元~） 库存 库存单位（个，件）  销量 一句话简介 详细介绍 商品图片
    public $config = ["name","price","price_unit","inventory","inventory_unit","sales_volume","subject","intro","pictures"];
    public $name = [
        'name' => '商品名',
        'dir' => 'name',
        'comment'=> '商品名',
        'type' => 'string',
        'view'=>'input',
        'show'=>1
    ];

    public $price = [
        'name'=> '价格',
        'dir'=>'price',
        'comment'=>'价格',
        'type'=>'integer',
        'default'=>0,
        'view'=>'input',
        'show'=>1
    ];

    public $price_unit = [
        'name' => '价格单位',
        'dir' => 'price_unit',
        'comment'=> '价格单位',
        'type' => 'string',
        'default'=>'元',
        'view'=>'input',
        'show'=>1
    ];


    public $inventory = [
        'name'=> '库存',
        'dir'=>'inventory',
        'comment'=>'库存',
        'type'=>'integer',
        'default'=>0,
        'view'=>'input',
        'show'=>1
    ];

    public $inventory_unit = [
        'name' => '库存单位',
        'dir' => 'inventory_unit',
        'comment'=> '库存单位',
        'type' => 'string',
        'default'=>'个',
        'view'=>'input',
        'show'=>1
    ];

    public $sales_volume = [
        'name' => '销量',
        'dir' => 'sales_volume',
        'comment'=> '销量',
        'type' => 'integer',
        'default'=>0,
        'view'=>'input',
    ];



    public $subject = [
        'name'=> '一句话简介',
        'dir'=>'subject',
        'comment'=>'分类简介',
        'type'=>'text',
        'view'=>'textarea',
        'show'=>1
    ];

    public $intro = [
        'name'=> '详细介绍',
        'dir'=>'intro',
        'comment'=>'详细介绍',
        'type'=>'mediumText',
        'view'=>'ueditor',
    ];

    // 文件上传4中view
    //  case "simple_img_upload":
    //  case "simple_file_upload":
    //  case "multi_img_upload":
    //  case "multi_file_upload":
    // 文件上传三种规则
    // file_name timestamp random_timestamp
    public $pictures = [
        'name'=> '产品图',
        'dir'=>'pictures',
        'comment'=>'产品图',
        'type'=>'mediumText',
        'view'=>'multi_img_upload->/public/commodity;jpn|png;random_timestamp',
    ];

    // 商品关联分类模型，这里是放置从自定义组件传上来的，会直接赋值给view
//    view=>select->mould:Classication&module:dir&m_id=ee&er=22 // 商品分类是下拉菜单，并且关联分类模型所实例化的dir模块,其余数据都是要发送到后端的数据

}