<?php
	function handle($arr){
	    $data = $arr['data'];
	    $m = new \App\Model\Menu();
	    $res = $m->addMenu($data);
		return $res;
	}
	?>