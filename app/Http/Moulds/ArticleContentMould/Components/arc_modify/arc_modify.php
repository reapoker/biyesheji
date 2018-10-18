<?php
	function handle($arr){
        $id = $arr['id'];
        $module_id = $arr['module_id'];
        $data = $arr['data'];
        // 直接添加，组件验证会在进入这个路由之前进行
        $module = \App\Model\Module::find($module_id);
        $cols = json_decode($module->config,true);
        $insert = [];
        foreach ($cols as $k => $v){
            if(!array_key_exists(trim($k),$data)) continue;
            $insert[trim($k)] = $data[trim($k)];
        }
        $id = DB::table($module->dir)->where('id',$id)->update($insert);
        if($id){
            return "修改成功！";
        }else{
            return false;
        }
	}
	?>