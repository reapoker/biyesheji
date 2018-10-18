<?php
function handle($arr)
{
    app()['cache']->forget('spatie.permission.cache');
    $data = $arr['data'];
    $menu = $data['menu'];
    $components = $data['components'];
    $role = \Spatie\Permission\Models\Role::findById($data['id']);
    // 刪除所有权限
    DB::table('role_has_permissions')->where('role_id',$data['id'])->delete();

    foreach ($menu as $v) {
        $permission = \Spatie\Permission\Models\Permission::firstOrCreate(['name' => $v]);
        try {  // 有的时候会出现，已经给了权限了，不能重复给权限，所以此处跳过
            $role->givePermissionTo($permission);
        } catch (\Exception $e) {
            continue;
        }
    }
    foreach ($components as $v) {
        $permission = \Spatie\Permission\Models\Permission::firstOrCreate(['name' => $v]);
        try {
            $role->givePermissionTo($permission);
        } catch (\Exception $e) {
            continue;
        }
    }
    return true;
}

?>