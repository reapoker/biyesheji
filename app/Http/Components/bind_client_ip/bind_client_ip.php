<?php
function handle($arr)
{
    $a = new \App\Libraries\GatewayOptions();
    // 先解绑原来的uid
    $a->bindUid($arr['client_id'],$arr['uid']);

    \App\Libraries\GatewayOptions::saveHistory($arr['uid']."上线了 :" . $arr['client_id']);

    return $arr->all();
}

?>