<?php
	function handle($arr){
		$res = \App\Model\Plugin::all(); // 获取所有数据库中的数据
		return $res;
	}
	?>