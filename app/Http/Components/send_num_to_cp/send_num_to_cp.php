<?php
function handle($arr)
{
    $uid = $arr['uid'];  // 裁判长uid
//    $cp_uid = $arr['cp_uid'];  // 要发送的裁判uid
    $num = $arr['num']; // 场上有多少人
    $a = new \App\Libraries\GatewayOptions();
    $ar = explode('-',$uid);
    $data = [
        'num'=>$num, 
        'type'=>'now_player_num',
        'area_id'=>$ar[0]  //  裁判编号
    ];
    if(array_key_exists('cp_uid',$arr)){
        $cp_uid = $arr['cp_uid'];
        $a->SendToUid($cp_uid,json_encode($data));
    }else{
        $a->sendToAll(json_encode($data));
    }
    return $arr;
}

?>