<?php
	function handle($arr){
        $m = new \App\Model\Module();
        // 获取模块列表
        // 获取每个模块可操作的模版映射
        if(!$arr['type'] || $arr['type'] == 'list'){
            return $m->getModuleList('list');
        }else{
            return $m->getModuleList('iteration');
        }
	}
	?>