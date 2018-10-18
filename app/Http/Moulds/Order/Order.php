<?php
namespace App\Http\Moulds\Order;
use App\Http\Moulds\BaseMould;

/**
 * Created by PhpStorm.
 * User: liuho
 * Date: 2018/2/27
 * Time: 13:17
 */

class Order extends BaseMould
{
    public $info = [
        'name' => '订单模型', // 名称
        'dir' => 'Order', // 唯一英文名，不可以重复
        'description' => '订单模型，与商品模型进行关联，实现提交订单',//以上三项为必填项，下方为选填项
        'author' => 'silsuer',
        'logo' => 'logo.jpg',
    ];

    public $template_map = [
        'index' => [
            'name'=> '订单列表',
            'template' => 'list.html',
            'show' => ['module'],
        ],
        'add' => [
            'name' => '未审核',
            'template'=>'add_commodity.html'
        ],
        'modify'=>[
            'name' => '修改订单',
            'template'=> 'modify_commodity.html'
        ]
    ];

    // 定义分类默认字段 订单编号 订单内容（json） 所属用户id 收件人 收件地址 提交时间 订单金额
    public $config = ["order_id","content","uid","recipients","address","submission_time","total"];
    public $order_id = [
        'name' => '订单编号',
        'dir' => 'order_id',
        'comment'=> '订单编号',
        'type' => 'string',
        'view'=>'input',
        'show'=>1
    ];

    public $content = [
        'name'=> '订单内容',
        'dir'=>'content',
        'comment'=>'订单内容',
        'type'=>'text',
        'view'=>'input',
    ];

    public $uid = [
        'name' => '所属用户id',
        'dir' => 'uid',
        'comment'=> '提交订单的用户id',
        'type' => 'integer',
        'default'=>0,
        'view'=>'input',
    ];


    public $recipients = [
        'name'=> '收件人',
        'dir'=>'recipients',
        'comment'=>'收件人',
        'type'=>'string',
        'view'=>'input',
        'show'=>1
    ];

    public $address = [
        'name' => '收件地址',
        'dir' => '$address',
        'comment'=> '收件地址',
        'type' => 'text',
        'view'=>'input',
    ];

    public $submission_time = [
        'name' => '提交时间',
        'dir' => 'submission_time',
        'comment'=> '订单提交时间',
        'type' => 'string',
        'view'=>'timer',
    ];

    public $total = [
        'name'=> '总计',
        'dir'=>'total',
        'comment'=>'订单总金额',
        'type'=>'integer',
        'view'=>'input',
        'show'=>1
    ];
}