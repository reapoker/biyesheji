<?php
	function handle($arr){
		$data = $arr['data'];
		$t = new \App\Http\Plugins\TemplateManager\TemplateManager();
		$res = $t->modify($data);
		return $res;
	}
	?>