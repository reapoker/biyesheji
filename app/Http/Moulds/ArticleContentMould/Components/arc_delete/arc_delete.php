<?php
	function handle($arr){
		$id = $arr['id'];
		$module_id = $arr['module_id'];
		$module = \App\Model\Module::find($module_id);
		DB::table($module->dir)->where('id',$id)->delete();
		return true;
	}
	?>