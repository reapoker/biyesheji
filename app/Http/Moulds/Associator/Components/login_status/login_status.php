<?php
function handle($arr)
{
    $user = auth()->user(); // 获取登录用户
    if($user){
        $data = $user->all();
        unset($data['password']);
        return $data;  // 去掉密码后返回其余数据
    }else{
        return false;
    }
}

?>