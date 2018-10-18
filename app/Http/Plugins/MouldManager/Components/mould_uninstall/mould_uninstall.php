<?php
	function handle($arr){
		$dir = $arr['dir'];
		$mould = \App\Model\Mould::where('dir',$dir)->first();
        if(!\App\Model\Module::where('model_id',$mould->id)->get()->isEmpty()){
            return ["该模型下存在模块，请删除所有模块后重试!",false];
        }
		$realDir = mould_path($dir);
		$m = new $realDir();
		$m->uninstall();
		return true;
	}
	?>