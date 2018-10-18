<?php
function handle($arr)
{
    $arr = $arr['data'];
    $pid = $arr['project_id'];
    $data = $arr['data'];
//    return $data;
    $p = DB::table('bs_xiangmu')->where('id', $pid)->first();
    $p = all_to_array($p);
    $name = $p['name'];
    foreach ($data as $v) {
        $u = [
            'order_id' => $v['order_id'],
            'original_orderid' => $v['order_id']
        ];
        DB::table('bs_yundongyuan')->where('id', $v['id'])->update($u);
    }
    return ['更新成功', true];
}

?>