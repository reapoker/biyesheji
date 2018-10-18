<?php
	function handle($arr){
		$c = new \App\Libraries\Component();
		$c->register($arr['data']);
		return true;
	}
	?>