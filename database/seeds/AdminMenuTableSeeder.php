<?php

use Illuminate\Database\Seeder;

class AdminMenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //在此处定义一个多维数组，以更新默认菜单列表
        $content_list = [
            'quick' => [
                'name' => '快捷操作',
                'name_en' => 'quick_bar',
                'authority_name' => 'quick_bar',
                'type' => 'content',
                'next' => [
                    'index' =>[
                        'name' =>'首页',
                        'name_en' => 'index',
                        'authority_name' => 'index',
                        'type' => 'content',
                    ],
                    'data_persistence' => [
                        'name' => '数据持久化',
                        'name_en' => 'data_persistence',
                        'authority_name' => 'data_persistence',
                        'type' => 'content'
                    ],
                    'im' => [
                        'name' => '聊天',
                        'name_en' => 'p.WebIM.box',
                        'authority_name' => 'im',
                        'type' => 'content'
                    ],
                    'email_system' => [
                        'name' => '站内邮箱',
                        'name_en' => 'email_system',
                        'authority_name' => 'email_system',
                        'type' => 'content'
                    ]
                ]
            ]
        ];

        $site_control_list = [
            'models_control' => [
                'name' => '模型管理',
                'name_en' => 'models_control',
                'authority_name' => 'models_control',
                'type' => 'site_control',
                'next' => [
                    'models_market' => [
                        'name' => '模型市场',
                        'name_en' => 'p.MouldManager.index',
                        'authority_name' => 'models_market',
                        'type' => 'site_control'
                    ],
                    'models_installed' => [
                        'name' => '已安装模型',
                        'name_en' => 'p.MouldManager.installed',
                        'authority_name' => 'models_installed',
                        'type' => 'site_control'
                    ]
                ]
            ],
            'modules_control' => [
                'name' => '模块管理',
                'name_en' => 'p.ModulesManager.index',
                'authority_name' => 'modules_control',
                'type' => 'site_control',
                'next' => [
                    'modules_list' => [
                        'name' => '模块列表',
                        'name_en' => 'p.ModulesManager.index',
                        'authority_name' => 'modules_list',
                        'type' => 'site_control'
                    ],
                    'modules_recycle_bin' => [
                        'name' => '模块回收站',
                        'name_en' => 'p.ModulesManager.recycle_bin',
                        'authority_name' => 'modules_recycle_bin',
                        'type' => 'site_control'
                    ]
                ]
            ],
            'components_control' => [
                'name' => '组件管理',
                'name_en' => 'components_control',
                'authority_name' => 'components_control',
                'type' => 'site_control',
                'next' => [
                    'components_library' => [
                        'name' => '组件库',
                        'name_en' => 'p.ComponentsManager.index',
                        'authority_name' => 'p.ComponentsManager.index',
                        'type' => 'site_control',
                    ],
                ]
            ],
            'rbac' => [
                'name' => '权限管理',
                'name_en' => 'rbac',
                'authority_name' => 'rbac',
                'type' => 'site_control',
                'next' => [
                    'roles_control' => [
                        'name' => '角色管理',
                        'name_en' => 'p.PermissionManager.role',
                        'authority_name' => 'roles_control',
                        'type' => 'site_control',
                    ],
                    'users_control' => [
                        'name' => '管理员管理',
                        'name_en' => 'p.PermissionManager.index',
                        'authority_name' => 'users_control',
                        'type' => 'site_control'
                    ]
                ]
            ],
            'system_control' => [
                'name' => '系统管理',
                'name_en' => 'system_control',
                'authority_name' => 'system_control',
                'type' => 'site_control',
                'next' => [
                    'system_config' => [
                        'name' => '系统配置',
                        'name_en' => 'system_config',
                        'authority_name' => 'system_config',
                        'type' => 'site_control'
                    ],
                    'db_control' => [
                        'name' => '数据字典',
                        'name_en'  => 'db_control',
                        'authority_name' => 'db_control',
                        'type' => 'site_control'
                    ],
                    'system_log' => [
                        'name' => '系统日志',
                        'name_en' => 'system_log',
                        'authority_name' => 'system_log',
                        'type' => 'site_control'
                    ]
                ]
            ],
            'plugins_manager' => [
                'name' => '插件管理',
                'name_en' => 'p.PluginsManager.index',
                'authority_name' => 'system_control',
                'type' => 'site_control',
                'next' => [
                    'plugins_manager' => [
                        'name' => '插件库',
                        'name_en' => 'p.PluginsManager.index',
                        'authority_name' => 'system_config',
                        'type' => 'site_control'
                    ]
                ]
            ]

        ];

        //开始插入
        foreach($content_list as $k => $v){
            $id = DB::table('admin_menus')->insertGetId([
                'name' => $v['name'],
                'name_en' => $v['name_en'],
                'authority_name' => $v['authority_name'],
                'type' => $v['type'],
                'pid' => 0
            ]);

            if (array_key_exists('next',$v)){
                foreach ($v['next'] as $kk => $vv){
                    $iid = DB::table('admin_menus')->insertGetId([
                        'name' => $vv['name'],
                        'name_en' => $vv['name_en'],
                        'authority_name' => $vv['authority_name'],
                        'type' => $vv['type'],
                        'pid' => $id,
                    ]);
                    if(array_key_exists('next',$vv)){
                        foreach ($vv['next'] as $kkk => $vvv){
                            DB::table('admin_menus')->insertGetId([
                                'name' => $vvv['name'],
                                'name_en' => $vvv['name_en'],
                                'authority_name' => $vvv['authority_name'],
                                'type' => $vvv['type'],
                                'pid' => $iid,
                            ]);
                        }
                    }
                }
            }
        }


        foreach($site_control_list as $k => $v){
            $id = DB::table('admin_menus')->insertGetId([
                'name' => $v['name'],
                'name_en' => $v['name_en'],
                'authority_name' => $v['authority_name'],
                'type' => $v['type'],
                'pid' => 0
            ]);

            if (array_key_exists('next',$v)){
                foreach ($v['next'] as $kk => $vv){
                    $iid = DB::table('admin_menus')->insertGetId([
                        'name' => $vv['name'],
                        'name_en' => $vv['name_en'],
                        'authority_name' => $vv['authority_name'],
                        'type' => $vv['type'],
                        'pid' => $id,
                    ]);
                    if(array_key_exists('next',$vv)){
                        foreach ($vv['next'] as $kkk => $vvv){
                            DB::table('admin_menus')->insertGetId([
                                'name' => $vvv['name'],
                                'name_en' => $vvv['name_en'],
                                'authority_name' => $vvv['authority_name'],
                                'type' => $vvv['type'],
                                'pid' => $iid,
                            ]);
                        }
                    }
                }
            }
        }


    }
}
