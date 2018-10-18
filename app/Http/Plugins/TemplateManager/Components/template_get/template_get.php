<?php
	function handle($arr){
		$t = new \App\Http\Plugins\TemplateManager\TemplateManager();
		$res = $t->get($arr['dir']);
		return $res;
	}
	?>