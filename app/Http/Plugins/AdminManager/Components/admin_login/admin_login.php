<?php
	function handle($arr){
	    $request = $arr['data'];
        if(isEmail($request['name'])){
            $attempt = ['email'=>$request['name'],'password'=>$request['password']];
        } else{
            $attempt = ['name'=>$request['name'],'password'=>$request['password']];
        }

//        dd($attempt);

        if(! $token = auth()->attempt($attempt)){
            return false;
        }else{
            return compact('token');
        }
	}
	?>