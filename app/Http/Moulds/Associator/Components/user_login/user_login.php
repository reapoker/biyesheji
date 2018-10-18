<?php
function handle($arr)
{
//  dd(config('auth.providers.users.model'));
//   dd($arr->all());

    //$user = $a->where('name',$arr['data']['name'])->where('password',$arr['data']['password'])->first();
    // 验证用户是否存在
    if(! $token = auth()->attempt($arr['data'])){
        return ["用户名或密码错误",false];
    }else{
         return compact('token');
    }
}

?>