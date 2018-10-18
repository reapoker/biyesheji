<?php
function handle($arr)
{
    // 更改运动员数据
    $from = $arr['from'];
    $to = $arr['to'];
    $data = $arr['data'];
    $d = [
        'type'=>$arr['name'],
        'from'=>$from,
        'to'=>$to,
        'data'=>$data
    ];
    $a = new \App\Libraries\GatewayOptions();
    $a->SendToUid($to,json_encode($d));
    return $arr;
}

?>