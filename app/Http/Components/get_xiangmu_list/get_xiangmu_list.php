<?php
function handle($arr)
{
    //dd('helloworld');
    if(array_key_exists('module_id',$arr)){
        // 返回项目列表
        $res = DB::table('bs_xiangmu')->get()->toArray();
        $res = all_to_array($res);
        $r = [];
        foreach($res as $v){
            $rr['key'] = $v['name'];
            $rr['value'] = $v['name'];
            $r[] = $rr;
        }

       return $r;
    }
    $uid = $arr['uid'];
    if($uid=='totalControl'||$uid=='scheduleRecord'){
        $res = DB::table('bs_xiangmu')->get();
    }else{
        $a = explode('-',$uid);
        $changdi_id = $a[0];
        $res = DB::table('bs_xiangmu')->where('area_id',$changdi_id)->get();
    }
    return all_to_array($res);
}



?>