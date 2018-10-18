<?php
    function handle($arr){
    if ($arr['delete_name'] == 'component_delete') return false;
    $d = new \App\Libraries\Component();
    $res = $d->remove($arr['delete_name']);
    return $res;
}

?>