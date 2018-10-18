<?php
	function handle($arr){
		$res = \App\Model\Mould::getInstalledMoulds(); // 获取已安装模型列表
        // 获取每个模型的设置列表  卸载和设置 . 每个模型的设置页面首页都必须为setting，如果有其他的，放置在下面
        foreach ($res as $k => $v){
            $dir = mould_path($v['dir']);
            $m = new $dir();
            $settings = $m->getSettingTemp();
            $res[$k]['settings'] = $settings;
        }

        return $res;
	}
	?>