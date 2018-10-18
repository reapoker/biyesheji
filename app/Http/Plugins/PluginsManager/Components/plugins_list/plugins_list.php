<?php
    // 获取所有插件列表
    function handle($arr){
        $p = new \App\Model\Plugin();
        $res = $p->getAll();
        return $res;
    }
?>