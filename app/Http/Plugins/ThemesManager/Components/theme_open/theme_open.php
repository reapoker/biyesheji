<?php
	function handle($arr){
		$p =new App\Http\Plugins\ThemesManager\ThemesManager();
		$p->setupTheme($arr['dir']);
		return true;
	}
	?>