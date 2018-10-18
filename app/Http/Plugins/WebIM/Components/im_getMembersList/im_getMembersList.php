<?php
	function handle($arr){
		$p = new \App\Http\Plugins\WebIM\Spider();
        $res = $p->bind($arr['client_id']);
        // 获取所有成员
        $list = \App\User::all()->toArray();
        $mine = ["username"=>"admin","id"=>"10000","avatar"=>"/assets/layouts/layout/img/avatar3_small.jpg"];
        $arr = [];
        $arr['groupname'] = "前端码屌";
        $arr['id'] = 1;
        $arr['list'] = [];
        foreach ($list as $k => $v){
            $a['username'] = $v['fullname'];
            $a['id'] = $v['id'];
            $a['avatar'] = "/assets/layouts/layout/img/avatar3_small.jpg";
            $a['sign'] = "测试数据";
            $a['status'] = "online";
            $arr['list'][] = $a;
        }
        $data['mine'] = $mine;
        $data['list'] = $arr;
        return $data;
	}
	?>