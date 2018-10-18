<?php
function handle($arr)
{
    $data = $arr['data'];
    $status = $arr['status'];
    if($status=="使用中"||$status=="已隐藏"||$status=="已禁用"){
        foreach ($data as $v){
            $module = \App\Model\Module::find($v);
            $module->status = $status;
            $module->save();
        }
        return true;  // 执行成功！
    }else{
        return ["参数错误！",false];
    }

}

?>