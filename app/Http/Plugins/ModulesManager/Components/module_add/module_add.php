<?php
	function handle($arr){
	    $request = $arr['data'];
            $model = \App\Model\Mould::find($request['model_id']); // 从选择的模型中获取模版映射
            $module = new \App\Model\Module();
            $module->name = $request['name'];
            $module->dir = $request['dir'];
            $module->description = $request['description'];
            $module->model_id = $request['model_id'];
            $module->module_id = $request['module_id'];
            $module->template_map = $model['template_map']; // 模版映射
            $module->config = $request['config']; // 配置映射
            $module->save();

            // 开始根据config，创建模块表
            $p = new \App\Libraries\ParseData();
            $p->createTable($request['dir'],$request['config']);
            return true;
	}
	?>