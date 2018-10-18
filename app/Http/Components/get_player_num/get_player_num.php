<?php
function handle($arr)
{
    $uid = $arr['uid']; // 裁判 1-1-caipan
    $arr = explode('-',$uid);
    $area_id = $arr[0] ; // 场地编号
    $cpz = $arr[0] . '-caipanzhang';
    $a = new \App\Libraries\GatewayOptions();
    $data = [
        'type'=>'get_player_num',
        'cp_uid'=>$uid
    ];
    $a->SendToUid($cpz,json_encode($data));
    return $arr;
}

?>