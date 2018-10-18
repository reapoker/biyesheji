<?php
	function handle($arr){
		$request = $arr['data'];
        $user = \App\Model\User::create([
            'name' => $request['name'],
            'fullname'=> $request['fullname'],
            'address' => $request['address'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
        ]);
        if(array_key_exists('roles',$request)){
            foreach ($request['roles'] as $v){
                $role = \Spatie\Permission\Models\Role::findById($v);
                $user->assignRole($role);
            }
        }
//        if(array_key_exists('roles',$request)){
//            foreach ($request['roles'] as $v){
//                $role = \Spatie\Permission\Models\Role::findById($v);
//                $user->assignRole($role);  // 分配角色
//            }
//        }
        if($user){
            return true;
        }else{
            return false;
        }
	}
	?>