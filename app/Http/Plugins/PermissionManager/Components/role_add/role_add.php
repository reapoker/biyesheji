<?php
	function handle($arr){
	    $arr = $arr['data'];
		$menu = $arr['menu'];
		$components = $arr['components'];
        // 先把权限表中的数据更新一下
        //updatePermissionsTable();

        // 创建角色并赋予权限
        $role = \Spatie\Permission\Models\Role::firstOrCreate(['name'=>$arr['name']]);
        foreach ($menu as $v){
            $permission = \Spatie\Permission\Models\Permission::firstOrCreate(['name'=>$v]);
            try{  // 有的时候会出现，已经给了权限了，不能重复给权限，所以此处跳过
                $role->givePermissionTo($permission);
            }catch (\Exception $e){
                continue;
            }

        }
        foreach ($components as $v){
            $permission = \Spatie\Permission\Models\Permission::firstOrCreate(['name'=>$v]);
            try{
                $role->givePermissionTo($permission);
            }catch (\Exception $e){
                continue;
            }
        }
        return true;  // 赋予权限后 返回成功
	}

	function updatePermissionsTable(){
	    $arr = handleComponent('permissions_list',[]);
	    $menu = $arr['menu'];
	    $components = $arr['components'];
	    foreach ($menu as $v){
	        \Spatie\Permission\Models\Permission::updateOrCreate(['name'=>$v['name_en']],['name'=>$v['name_en']]);
        }

        foreach ($components as $v){
	        foreach ($v as $vv){
	            \Spatie\Permission\Models\Permission::updateOrCreate(['name'=>$vv['name']],['name'=>$vv['name']]);
            }
        }

        return $arr; // 返回权限数据
    }

	?>