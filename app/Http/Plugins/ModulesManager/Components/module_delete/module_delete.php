<?php
	function handle($arr){
		$data = $arr['data'];
		foreach ($data as $v){
		    $id = $v;
		    $module = \App\Model\Module::find($id); // 获取模块信息
            // 删除模块表中的信息，并且删除该模块对应的表
            \App\Model\Module::where('id',$id)->delete();
            \Illuminate\Support\Facades\Schema::dropIfExists($module->dir);

        }
        return true;
	}
	?>