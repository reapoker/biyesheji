<?php
function handle($arr)
{
    $arr = $arr['data'];
    $project_id = $arr['projectID'];
    $id = $arr['placeID'];
    $judge_num = $arr['judgeNum'];
    $modify = [
        'judge_num'=>$judge_num,
        'project_list'=>join(',',$project_id)
    ];
    DB::table('area')->where('id',$id)->update($modify);
    return $arr;
}

?>