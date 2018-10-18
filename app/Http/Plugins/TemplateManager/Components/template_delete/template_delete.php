<?php
	function handle($arr){
		$dir = $arr['dir'];
		$t = new App\Http\Plugins\TemplateManager\TemplateManager();
		$res = $t->delete($dir);
		if(empty($res)){
		    return true;
        }else{
            return $res;
        }
	}
	?>