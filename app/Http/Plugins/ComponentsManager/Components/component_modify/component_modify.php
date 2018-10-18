<?php
	function handle($arr){
	    $request = $arr['data'];
        $a = new \App\Libraries\Component();
        $r1 = $a->remove($request['old_name']);
        $r2 = $a->register($request);
        if($r1 && $r2){
            return true;
        }
	}
	?>