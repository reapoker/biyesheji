<?php
	function handle($arr){
		$type = $arr['menu_type']; // 获取要更新的菜单类型
        \App\Model\Menu::where('type',$type)->update(['order_id'=> 960418]);
		$data = $arr['data'];// 获取要更新的数据
        if(empty($data)||$data==[]){
            \App\Model\Menu::where('order_id',960418)->delete();
            return true;
        }else{
            $m = new \App\Model\Menu();
            $res = $m->menuUpdate($type,$data);
            \App\Model\Menu::where('order_id',960418)->delete();
            return $res;
        }

	}
	?>