<?php
function handle($arr)
{
    $id = $arr['place_id'];
    DB::table('area')->where('id',$id)->delete();
    \App\Libraries\GatewayOptions::saveHistory("总控删除了场地 $id");

    return $arr;
}

?>