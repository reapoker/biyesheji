<?php

namespace App\Http\Moulds\ArticleContentMould;

/**
 * Created by PhpStorm.
 * 文章内容模型
 * User: silsuer
 * Date: 18/1/8
 * Time: 下午                                                                                                                                                                                          5:19
 */

use App\Http\Moulds\BaseMould;
use App\Model\Model;
use App\Model\Mould;

class ArticleContentMould extends BaseMould
{
    public $info = [
        'name' => '文章内容模型', // 名称
        'dir' => 'ArticleContentMould', // 唯一英文名，不可以重复
        'description' => '文章内容模型，用于文章发布',//以上三项为必填项，下方为选填项
        'author' => 'silsuer',
        'logo' => 'logo.jpg',
    ];

    // 该模型在后台中的模版映射 show中是个数组，里面写的是判断在模块列表更多操作中出现还是在已安装模型中出现
    public $template_map = [
        'index' => [
            'name'=> '内容列表',
            'template' => 'list.html',
            'show' => ['module'],
        ],
        'auditing' => [
            'name' => '待审核',
            'template' => 'auditing.html',
            'show' => ['module'],
        ],
        'recycle' => [
            'name' => '回收站',
            'template' => 'recycle_bin.html',
            'show' => ['module'],
        ],
        'setting' => [
            'name' => '设置',
            'template' => 'setting.html',
            'show' => ['setting'],
        ],
        'add' => [
            'name' => '添加文章',
            'template'=>'add_article.html'
        ],
        'modify'=>[
            'name' => '修改文章',
            'template'=> 'modify_article.html'
        ]
    ];





    // 文章内容模型配置项,配置整个模块
    // 配置项第一项：对应模块建立时所需的默认表的字段，语法依据laravel的验证语法,配置单个模块内容发布时
    // required 必须
    // unique 验证唯一
    // string 字符串 :255 255个字节的varchar
    // text、mediumText 文章 :markdown/editor/default:ddd 选择文章编辑器以及
   /*
    * name 字段的名字，任意字符，可中文可英文
    * dir 字段标识 ，任意英文字符
    * comment 字段注释，任意字符串，可中文可英文
    * type 字段类型 increments int string text mediumText
    * view 字段表现形式
    *
    * validate 字段验证规则 与laravel中的验证规则一致
    * default
    * show 标记这个字段是否在列表中出现
    * */
    public $config = ["title","subject","content","time","tags","status","password","review"];
    public $title = [
        'name' => '标题',
        'dir' => 'title',
        'comment'=> '每篇文章的标题',
        'type' => 'string',
        'view'=>'input',
        'validate'=>'required',
        'show'=>1,
        ];
    public $subject = [
        'name' => '主题',
        'dir' => 'subject',
        'comment'=> '每篇文章的简介',
        'type' => 'text',
        'view'=>'input'
    ];
    public $content = [
        'name' => '内容',
        'dir' => 'content',
        'comment'=> '文章内容',
        'type' => 'mediumText',
        'view'=>'markdown',
        'validate'=>'required'
    ];
    public $time = [
        'name' => '发布时间',
        'dir' => 'time',
        'comment'=> '文章发布的时间',
        'type' => 'string',
        'view'=>'timer',
        'validate'=>'required',
        'show'=>1,
    ];

    public $tags = [
        'name' => '标签',
        'dir' => 'tags',
        'comment'=> '文章个性化标签',
        'type' => 'string',
        'view'=>'input',
    ];
    public $status = [
        'name' => '状态',
        'dir' => 'status',
        'comment'=> '文章所处的状态',
        'type' => 'string',
        'default'=> '已发布',
        'view'=>'select->草稿|等待审核|已发布|密码验证|隐藏|回收站',
        'validate'=>'required',
        'show'=>1,
    ];
    public $password = [
        'name' => '密码',
        'dir' => 'password',
        'comment'=> '加密文章的密码',
        'type' => 'string',
        'view'=>'password',
    ];
    public $review = [
        'name' => '审核',
        'dir' => 'review',
        'comment'=> '文章是否经过审核',
        'type' => 'string',
        'view'=>'radio->是|否',
        'validate'=>'required'
    ];


    public $validate = []; // 这里面写要进行验证的组件名以及验证规则


}