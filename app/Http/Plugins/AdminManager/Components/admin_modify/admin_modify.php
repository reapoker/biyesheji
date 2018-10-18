<?php
function handle($arr){
    $request = $arr['data'];
    $id = $request['id'];
    if($request['password'] && $request['password']!=''){
        $user = \App\User::where('id',$id)->update([
            'name' => $request['name'],
            'fullname'=> $request['fullname'],
            'address' => $request['address'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
        ]);
    }else{
        $user = \App\User::where('id',$id)->update([
            'name' => $request['name'],
            'fullname'=> $request['fullname'],
            'address' => $request['address'],
            'email' => $request['email']
        ]);
    }


    $user = \App\User::find($id);
    $user->syncRoles($request['roles']);
    if($user){
        return true;
    }else{
        return false;
    }
}
	?>