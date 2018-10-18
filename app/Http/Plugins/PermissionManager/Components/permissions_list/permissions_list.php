<?php
	function handle($arr){
	    $data = []; //要返回的数据
        $data['components'] = []; // 组件集合
        $data['menu'] = []; // 菜单集合
		// 获取所有权限列表
        // 获取菜单列表 一级菜单与二级菜单
        $menu = \App\Model\Menu::with(['children'])->get()->toArray();
        foreach ($menu as $k => $v){
            if($v['pid'] != 0){
                unset($menu[$k]); // 删掉一级菜单的多余数组
            }
        }
        $data['menu'] = $menu;
        // 获取组件列表  模型 + 插件 + 自定义组件

        // 获取所有模型名，插件名
        $moulds = getMoulds();  // 获取模型列表
        $plugins = getPlugins();  // 获取插件列表
        $arr = array_merge($moulds,$plugins); //合并后获取模型+插件列表
        $arr[] = 'dev';  // 把自定义组件也写进去
        $c = new \App\Libraries\Component();
        $components = $c->components; // 获取所有组件列表
        foreach ($arr as $k => $v){
            $data['components'][$v] = [];
            foreach ($components as $k => $vv){
                if($vv['belongTo'] == $v){
                    $data['components'][$v][] = $vv;
                }
            }
        }
       return $data;
	}


	function getMoulds(){
        $moulds_path = app_path() . '/Http/Moulds';
        $m = scandir($moulds_path);
        $moulds = [];
        foreach ($m as $k => $v){
            if($v=='.'||$v=='..'||strpos($v,'.php')) continue;
            $moulds[] = $v;
        }
        return $moulds;
    }

    function getPlugins(){
        $plugins_path = app_path() . '/Http/Plugins';
        $p = scandir($plugins_path);
        $plugins = [];
        foreach ($p as $k => $v){
            if($v=='.'||$v=='..'||strpos($v,'.php')) continue;
            $plugins[] = $v;
        }
        return $plugins;
    }
	?>