<?php
function handle($arr)
{
    $uid = $arr['uid'];
    $arr = $arr['data'];
    $id = $arr['id'];
    $value = $arr['order_id'];
    DB::table('bs_yundongyuan')->where('id',$id)->update(['order_id'=>$value]);
    return $arr;
}

?>