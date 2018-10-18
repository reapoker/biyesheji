<?php
function handle($arr)
{
    $arr = $arr->all();
    $uid = $arr['uid']; // 裁判uid
    $a = explode('-',$uid);
    $cpz_uid = $a[0]. '-caipanzhang';
    $arr['type'] = 'get_cp_mark';
    $aa = new \App\Libraries\GatewayOptions();
    $aa->SendToUid($cpz_uid,json_encode($arr));
    \App\Libraries\GatewayOptions::saveHistory('裁判打分: ' . json_encode($arr));

    return "success";
}

?>