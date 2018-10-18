<?php
	function handle($arr){
		$dir = $arr['dir'];
        $dir = mould_path($dir);
        $mould = new $dir();
        $mould->install();
        return true;
	}
	?>