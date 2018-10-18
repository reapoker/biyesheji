<?php
	function handle($arr){

	    $request = $arr['data'];


        try{
            $model = \App\Model\Mould::find($request['model_id']); // 从选择的模型中获取模版映射
            $module = \App\Model\Module::find($request['id']);
            // 根据表的列，修复config中的值？
            //TODO 开始根据config，修改模块表
            $p = new \App\Libraries\ParseData();
            $p->syncTable($module->dir,$module->config,$request['dir'],$request['config']);
            $module->name = $request['name'];
            $module->dir = $request['dir'];
            $module->description = $request['description'];
            $module->model_id = $request['model_id'];
            $module->module_id = $request['module_id'];
            $module->template_map = $model['template_map']; // 模版映射
            $module->config = $request['config']; // 配置映射
            $module->save();
            return true;
        }catch (\Exception $e){
            return [$e->getMessage(),false];
        }
	}
	?>