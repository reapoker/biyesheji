<?php
	function handle($arr){
		$p = new \App\Http\Plugins\WebIM\Spider();
		$p->sendToAll($arr['content']);
		return "发送成功！";
	}
	?>