<?php
	function handle($arr){
		$p = new \App\Http\Plugins\ThemesManager\ThemesManager();
		$list = $p->getList();
		return $list;
	}
	?>