<?php
	function handle($arr){
		$res = \App\Model\Mould::getLocalMould();
		return $res;
	}
	?>