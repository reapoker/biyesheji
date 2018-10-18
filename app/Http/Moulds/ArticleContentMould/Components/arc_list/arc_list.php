<?php
	function handle($arr){
		$data = [];
	    $id = $arr['id'];
		$module = \App\Model\Module::find($id);
		$config = json_decode($module->config,true);
		$cols = ['id']; // 默认必须取得id
        $tableHeader = ['id']; // 表头列名,默认是id
		foreach ($config as $k => $v){
		    if($k==""||$v==""){
		        unset($config[$k]);
		        continue;
            }
            $attr = json_decode(trim($v),true);
		    if(array_key_exists('show',$attr) && $attr['show'] ==1 ){
		        $cols[] = trim($k); // 把确定好的字段传入其中
                $tableHeader[] = $attr['name'];
            }
        }

		$list = DB::table($module->dir)->get($cols)->toArray();
		$data['tableHeader'] = $tableHeader;
		$data['cols'] = $cols;
		$data['list'] = $list;
		return $data;
	}
	?>