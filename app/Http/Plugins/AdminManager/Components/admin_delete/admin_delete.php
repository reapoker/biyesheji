<?php
	function handle($arr){
		$id = $arr['id'];
		if($id==1) return false; // 超级管理员不能删除
		$user = \App\Model\User::find($id); // 获取用户
		$roles = $user->getRoleNames(); // 获取角色集合
        foreach ($roles as $v){
            // 从角色客户关联表中删除所有关联项
            // 获取角色id  获取用户id，去表中删除
            $user_id = $user->id;
            $role = DB::table('roles')->where('name',$v)->first();
            DB::table('model_has_roles')->where('role_id',$role->id)->where('model_id',$user_id)->delete();
//            $user->removeRole($v); // 删除角色
        }
        $res =\App\Model\User::where('id',$id)->delete(); // 删除管理员
        if($res){
            return true;
        }else{
            return false;
        }
	}
	?>