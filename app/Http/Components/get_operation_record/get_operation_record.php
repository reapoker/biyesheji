<?php
function handle($arr)
{
    $res = DB::table('bs_history')->get();
    $res = all_to_array($res);
    return $res;
}

?>