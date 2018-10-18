<?php
	function handle($arr){
	    $data = [];
		$id = $arr['id'];
		$user = \App\User::find($id);
		$data['user'] = $user->toArray();
		// 获取用户的所有角色，获取所有角色列表
        $userRoles = $user->getRoleNames(); // 获取管理员的所有角色
        $roles = \Spatie\Permission\Models\Role::all()->toArray(); // 获取角色列表
        foreach ($roles as $k => $v){
            if(checkRole($v['name'],$userRoles)){
                $roles[$k]['is_role'] = 1;
            }
        }
        $data['roles'] = $roles;
		return $data;
	}

	function checkRole($name,$list){
	    foreach ($list as $v){
	        if($v == $name){
	            return true;
            }
        }
    }
	?>