<?php
	function handle($arr){
	    $p = new \App\Model\Menu();
        $res = $p->getTopList();
		return $res;
	}
	?>