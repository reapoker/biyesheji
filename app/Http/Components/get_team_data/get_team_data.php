<?php
function handle($arr)
{
    $d = DB::table('bs_yundongyuan')->pluck('danwei');
    $d = all_to_array($d); // 转为数组
    $d = array_unique($d);
    $res = [];
    foreach ($d as $v){
        $r['name'] = $v;
        $r['data'] = all_to_array(DB::table('bs_yundongyuan')->where('danwei',$v)->get());
        $res[] = $r;
    }
//    dump($res);
    return all_to_array($res);
}

?>