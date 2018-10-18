<?php
	 function handle($arr){
		$m = new \App\Model\Menu();
		$res = $m->getContentList();
		if(empty($res) || $res ==[]){
		    $res = true;
        }
		return $res;
	}
	?>