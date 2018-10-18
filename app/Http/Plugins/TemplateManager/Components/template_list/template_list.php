<?php
	function handle($arr){
		$t = new App\Http\Plugins\TemplateManager\TemplateManager();
		$res = $t->tempaltes;
		if(empty($res)){
		    return true;
        }else{
		    return $res;
        }
	}
	?>