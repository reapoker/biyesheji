<?php
	function handle($arr){
		$d = new \App\Libraries\Component();
		$res = $d->renderComponentsJson();
		return $res;
	}
	?>