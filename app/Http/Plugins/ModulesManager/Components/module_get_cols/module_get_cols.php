<?php
	function handle($arr){
        $mould_id = $arr['m_id'];
        $module_id = $arr['u_id'];
        $module = \App\Model\Module::find($module_id);
        if($module_id=="0"||$module->model_id != $mould_id){ // 如果模块不是顶级模块，或者模块的模型和选得模型不一致
            $mould =  \App\Model\Mould::find($mould_id); // 返回选得模型的config
            return json_decode($mould->config);
        }else{
            return json_decode($module->config); // 返回模块的config
        }
	}
	?>