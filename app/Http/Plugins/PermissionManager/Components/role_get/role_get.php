<?php
function handle($arr)
{
    $id = $arr['id'];
    $data = [];
    $data['name'] = \Spatie\Permission\Models\Role::findById($id)->name;
    $data['id'] = $id;
    $permissions =role_has_permissions($id);
    $permissions_list = getList('permissions_list',[]);
    $data['permission_list'] = checkPermission($permissions,$permissions_list);
    return $data;
}

function checkPermission($permissions,$permissions_list){
    // 遍历menu 做标记
    foreach ($permissions_list['menu'] as $k => $v){
        if(checkP($permissions,$v['name_en'])){
            // 如果一级菜单中存在权限
            $permissions_list['menu'][$k]['is_permission'] = 1;
        }
        if(!empty($v['children'])){
            foreach ($v['children'] as $kk => $vv){
                if(checkP($permissions,$vv['name_en'])){
                    $permissions_list['menu'][$k]['children'][$kk]['is_permission'] = 1;
                }
            }
        }
    }
    // 遍历组件 做标记
    foreach ($permissions_list['components'] as $k => $v){
        foreach ($v as $kk => $vv){
            if(checkP($permissions,$vv['name'])){
                $permissions_list['components'][$k][$kk]['is_permission'] = 1;
            }
        }
    }

    return $permissions_list;
}

function checkP($list,$name){
    foreach ($list as $v){
        if($v['name']== $name){
            return true;
        }
    }
    return false;
}

function role_has_permissions($id){
    $data = [];
    $arr = DB::table('role_has_permissions')->where('role_id',$id)->get()->toArray();

    foreach ($arr as $v){
        $permission = \Spatie\Permission\Models\Permission::find($v->permission_id)->toArray();
        $data[] = $permission;
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

function getList(){
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