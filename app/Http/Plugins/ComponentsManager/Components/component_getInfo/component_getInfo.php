<?php
	function handle($arr){
	    $request = $arr['data'];
        $name = $request['name'];
        $model_name = $request['model_name'];
        $c = new \App\Libraries\Component();
        $res = $c->get($name);
        if($res){
            return $res;
        }else{
            return false;
        }
	}
	?>