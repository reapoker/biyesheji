<?php
	function handle($arr){
		$data = $arr['data']; // 把数据添加到json文件里
        $t = new App\Http\Plugins\TemplateManager\TemplateManager();
        $res = $t->register($data);
        return $res;
	}

	?>