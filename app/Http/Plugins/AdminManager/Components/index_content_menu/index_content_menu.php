<?php
	function handle($arr){

		$menu = [];
	    // 此处应该先查看当前登录用户有哪些菜单权限，只返回当前用户可以访问的菜单
        $m = new \App\Model\Menu();
        $quick = $m->getContentQuickList();
        $content = $m->getContentList();
        $user = auth()->user();

        if($user->id != 1){
            foreach ($quick as $k => $v){
                if(!$user->hasPermissionTo($v['name_en'])){
                    // 如果没有权限的话
                    unset($quick[$k]);
                }
                if(array_key_exists($k,$quick) && array_key_exists('children',$quick[$k])){
                    foreach ($quick[$k]['children'] as $kk => $vv){
                        if(!$user->hasPermissionTo($vv['name_en'])){
                            unset($quick[$k]['children'][$kk]);
                        }
                    }
                }
            }

            foreach ($content as $k => $v){
                if(!$user->hasPermissionTo($v['name_en'])){
                    // 如果没有权限的话
                    unset($content[$k]);
                }
                if(array_key_exists($k,$content) && array_key_exists('children',$content[$k])){
                    foreach ($content[$k]['children'] as $kk => $vv){
                        if(!$user->hasPermissionTo($vv['name_en'])){
                            unset($content[$k]['children'][$kk]);
                        }
                    }
                }
            }
        }

        $menu['common'] = $content;
        $menu['quick'] = $quick;
        return $menu; // 返回菜单
	}
	?>