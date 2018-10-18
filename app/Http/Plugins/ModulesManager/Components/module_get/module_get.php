<?php
	function handle($arr){
	    $id = $arr['id'];
	    $res = \App\Model\Module::find($id);
	    if($res){
            return $res;
        }else{
	        return false;
        }

	}
	?>