<?php
	function handle($arr){
		$res = \Spatie\Permission\Models\Role::all()->toArray();
		if(empty($res)){
		    return true;
        }else{
		    return $res;
        }

	}
	?>