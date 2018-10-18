<?php
	function handle($arr){
          // 传入模块id
        $id = $arr['id'];
        // 获取模块中的字段配置
        $module = \App\Model\Module::find($id);
        return json_decode($module->config);
	}
	?>