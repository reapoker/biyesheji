<?php
	function handle($arr){
	    $data = $arr['data'];
		$insert = [
		    'name'=>$data['name'],
		    'password'=>bcrypt($data['password']),
		    'mobile'=>$data['tel'],
        ];
		// 判断有几个会员模块？ 如果有一个，那么就写到那一个里
        $mould = \App\Model\Mould::where('dir','Associator')->first();
        $count = \App\Model\Module::where('model_id',$mould->id)->count();
        if($count==1){

            // 只有一个会员模块，直接使用这个模块
            $module = \App\Model\Module::where('model_id',$mould->id)->first();
//            $associator = new \App\Model\Associator();
//            $associator->setTable($module->dir);
            $nCount = DB::table($module->dir)->where('name',$data['name'])->get()->count();
            if($nCount!=0){
                return ["该用户名已被注册！",false];
            }
            $mCount = DB::table($module->dir)->where('mobile',$data['tel'])->count();
            if($mCount!=0){
                return ["该手机号已被注册！",false];
            }


            DB::table($module->dir)->insert($insert);
        }
        return true;
	}
	?>