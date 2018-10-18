<?php
function handle($arr)
{
    $id = $arr['id']; // 获取id
    $a = \Spatie\Permission\Models\Role::where('id',$id)->delete();  // 删除 角色
    $b = DB::table('role_has_permissions')->where('role_id',$id)->delete(); //删除与角色关联的权限
    return true;

}

?>