<?php
function handle($arr)
{
    $uid = $arr['uid'];
    $arr = $arr['data'];
    $id = $arr['id'];
    $value = $arr['giveup'];
    $order_id = $arr['order_id'];
    DB::table('bs_yundongyuan')->where('id',$id)->update(['give_up'=>$value,'order_id'=>$order_id]);
    $m = new \App\Libraries\GatewayOptions();
    $m->SendToUid($uid,json_encode($arr));
    return $arr;
}

?>