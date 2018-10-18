<?php
function handle($arr)
{
    $data = $arr['data'];
    $judge_num =  $data['judgeNum'];
    $project_list = join(',',$data['projectID']);
    $d = [
      'judge_num'=>$judge_num,
      'project_list'=>$project_list
    ];

    DB::table('area')->insert($d);  // 入库
    \App\Libraries\GatewayOptions::saveHistory("总控添加了场地 ". json_encode($d));
    return $arr->all();
//    return $arr;
}

?>