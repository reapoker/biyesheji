<?php
	function handle($arr){
		$module_id = $arr['module_id'];
		$id = $arr['id'];
		$module = \App\Model\Module::find($module_id);
		$res = DB::table($module->dir)->where('id',$id)->first();
		$data = [];
		$data['details'] = $res;
		$data['cols'] = json_decode($module->config,true);
		return $data;
	}
	?>