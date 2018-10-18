<?php
	function handle($arr){
		$res = \App\Model\User::all()->toArray(); // 获取所有管理员
        return $res;
	}
	?>