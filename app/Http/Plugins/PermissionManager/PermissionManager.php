<?php
/**
 * Created by PhpStorm.
 * User: liuho
 * Date: 2018/2/8
 * Time: 10:56
 */

namespace App\Http\Plugins\PermissionManager;


use App\Http\Plugins\BasePlugins;

class PermissionManager extends BasePlugins
{
        public $info = [
          'name' => '权限管理',
          'dir' => 'PermissionManager',
          'description' => '后台权限管理插件'
        ];

        public $template_map = [
          'index' => [
              'name' => '管理员管理',
              'template' => 'index.html'
          ],
            'role' =>[
                'name' => '角色管理',
                'template' => 'role.html'
            ],
            'role_add'=>[
                'name' => '角色添加',
                'template' => 'role_add.html'
            ],
            'role_modify' => [
                'name'=> '角色修改',
                'template' => 'role_modify.html'
            ],
            'admin_add' => [
                'name' => '添加管理员',
                'template' => 'admin_add.html'
            ],
            'admin_modify'=>[
                'name' => '修改管理员',
                'template' => 'admin_modify.html'
            ]
        ];
}