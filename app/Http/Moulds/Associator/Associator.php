<?php
namespace App\Http\Moulds\Associator;
/**
 * Created by PhpStorm.
 * User: liuho
 * Date: 2018/2/27
 * Time: 13:17
 */

class Associator extends \App\Http\Moulds\BaseMould
{
    public $info = [
        'name' => '会员模型', // 名称
        'dir' => 'Associator', // 唯一英文名，不可以重复
        'description' => '会员模型，为前台提供会员服务',//以上三项为必填项，下方为选填项
        'author' => 'silsuer',
        'logo' => 'logo.jpg',
    ];

    public $template_map = [
        'index' => [
            'name'=> '会员列表',
            'template' => 'list.html',
            'show' => ['module'],
        ],
        'setting' => [
            'name' => '设置',
            'template' => 'setting.html',
            'show' => ['setting'],
        ],
        'add' => [
            'name' => '添加会员',
            'template'=>'add_associator.html'
        ],
        'modify'=>[
            'name' => '修改会员',
            'template'=> 'modify_associator.html'
        ]
    ];

    // 定义会员默认字段
    public $config = ["name","password","fullname","sex","birth","email","mobile","avatar","integration"];
    public $name = [
        'name' => '用户名',
        'dir' => 'name',
        'comment'=> '用户名',
        'type' => 'string',
        'view'=>'input'
    ];

    public $password = [
        'name' => '密码',
        'dir' => 'password',
        'comment'=> '密码',
        'type' => 'string',
        'view'=>'password'
    ];

    public $sex = [
      'name'=>'性别',
      'dir'=>'sex',
      'comment'=>'性别',
      'type'=>'string',
      'view'=>'radio->男|女'
    ];

    public $fullname = [
        'name' => '真实姓名',
        'dir'=>'fullname',
        'comment'=>'真实姓名',
        'type'=> 'string',
        'view'=>'input'
    ];

    public $birth = [
        'name' => '出生日期',
        'dir'=>'birth',
        'comment'=>'出生日期',
        'type'=> 'string',
        'view'=>'input'
    ];

    public $email = [
        'name' => '邮箱',
        'dir'=>'email',
        'comment'=>'邮箱地址',
        'type'=> 'string',
        'view'=>'input'
    ];

    public $mobile = [
        'name' => '联系方式',
        'dir'=>'mobile',
        'comment'=>'联系方式',
        'type'=> 'string',
        'view'=>'input'
    ];

    public $avatar = [
        'name' => '头像',
        'dir'=>'avatar',
        'comment'=>'头像，有一个默认头像',
        'type'=> 'string',
        'default'=>'/css/avatar.jpg',
        'view'=>'simple_img_upload->/Storage/Upload/;jpg|png;file_name',
    ];

    public $integration = [
        'name' => '积分',
        'dir'=>'integration',
        'comment'=>'积分，用于会员模型内置的积分系统',
        'default'=>'0',
        'type'=> 'string',
        'view'=>'input'
    ];
}