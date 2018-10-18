<?php
function handle($arr)
{
    $uid = $arr['uid'];
    $id = $arr['projectID'];
    $xiangmu = DB::table('bs_xiangmu')->find($id);
    $a = explode('-',$uid);
    $area_id = $a[0];
    $res = DB::table('bs_yundongyuan')->where('zubie',$xiangmu->name)->get();
    $t = new \App\Libraries\GatewayOptions();
    $xiangmu = all_to_array($xiangmu);
    $data = [];
    $data['type'] = 'initDB';
    $data['data'] = all_to_array($res);
    // 向场地裁判长发送数据
    if(count($a)==2&&$a[1]=='bigScreen'){
//        $data['type'] = 'get_project_data';
//        $t->SendToUid($uid,json_encode($data));
        $res = DB::table('bs_yundongyuan')->where('zubie',$xiangmu['name'])->whereRaw('paiming is not null')->orderBy('paiming')->limit(16)->get();
        $res = all_to_array($res);
        $data['type'] = 'get_project_data';
        $data['data'] = $res;
    }
    $t->SendToUid($uid,json_encode($data));
    // 通知总裁更新场地名
//    $d = [
//        'type'=>'get_project_name',
//        'name'=>$xiangmu['name']
//    ];
//    $t->SendToUid("finalJudge",json_encode($d));
    return $data;
//    $a = DB::table('bs_yundongyuan')->where('id',44)->get();
//    $a = all_to_array($a);
//    $ddd = [
//        'type' => 'initDB',
//        'data'=>$a,
//    ];
//    return $ddd;
}

?>