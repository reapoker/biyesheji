<?php
function handle($arr)
{
    $res = DB::table('area')->get();
    $res = all_to_array($res);
    foreach ($res as $k=>$v){
        $s = [];

        $list = explode(',',$v['project_list']);
        foreach ($list as $vv){
            $r = DB::table('bs_xiangmu')->where('id',$vv)->first();
            $r = all_to_array($r);
            $s[] = $r['name'];
        }
        $res[$k]['project_list'] = join(',',$s);
        $res[$k]['project_id'] = $list;
    }


    return $res;
}

?>