<?php


function handle($arr)
{
    // 总裁确认，此时把运动员数据入库，然后向裁判长发送确认消息
    $to = $arr['to'];
    //    $from = $arr['from'];
//    $player_id = $arr['data']['id'];
    $player_id = $arr['player_id'];
    $data = $arr['data'];
    DB::table('bs_yundongyuan')->where('id', $player_id)->update($data);
    $c = new \App\Libraries\GatewayOptions();
    $d = [
        'type' => 'final_judge_confirm_player',
        'data' => $data
    ];
//    $c->SendToUid($to, json_encode($d));
    \App\Libraries\GatewayOptions::saveHistory("总裁确认了裁判打分:". json_encode($d));

    return $arr->all();
}

?>