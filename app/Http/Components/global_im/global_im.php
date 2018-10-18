<?php
function handle($arr)
{
    $form = $arr['from'];
    $to = explode(',',$arr['to']);
    $type = $arr['type'];
    $c = new \App\Libraries\GatewayOptions();
    if($arr['to']=='all'){
        $c->sendToAll(json_encode($arr->all()));  // 全局发送
    }else{
        foreach ($to as $vv){
            $c->SendToUid($vv,json_encode($arr->all())); // 单独发送
        }
    }

//    \App\Libraries\GatewayOptions::saveHistory("通用通讯组件：" . json_encode($arr->all()));

    return $arr;
}

?>