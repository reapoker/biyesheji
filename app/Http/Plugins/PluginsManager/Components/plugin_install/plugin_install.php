<?php
	function handle($arr){
	    $name = $arr['install_name'];
	    $p = new \App\Model\Plugin();
	    $res = $p->install($name);
		return $res;
	}
	?>