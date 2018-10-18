<?php
	function handle($arr){
		$data = $arr['data'];
		// 直接添加，组件验证会在进入这个路由之前进行
        $module = \App\Model\Module::find($data['module_id']);
        $cols = json_decode($module->config,true);
        $insert = [];
        foreach ($cols as $k => $v){
            if(!array_key_exists(trim($k),$data)) continue;
            $insert[trim($k)] = $data[trim($k)];
        }
        $id = DB::table($module->dir)->insertGetId($insert);
        if($id){
            return "添加成功！";
        }else{
            return false;
        }
	}
	?>