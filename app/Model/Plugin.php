<?php

namespace App\Model;

use App\Http\Plugins\MenuManager\MenuManager;
use Illuminate\Database\Eloquent\Model;

class Plugin extends Model
{
    protected $table = 'plugins';

    // 去插件目录中获取全部插件
    public function getAll(){
        $baseUrl = app_path() . '/Http/Plugins';
        $dirs = scandir($baseUrl);
        $arr = [];
        foreach ($dirs as $v){
            if($v == '.'||$v=='..'||strpos($v,'.php')) continue;
                $dir = '\App\Http\Plugins\\'. $v . '\\' . $v;
                $p = new $dir();
                $arr[] = $p->info;
        }
        return $arr; // 返回插件列表
    }

    // 安装插件
    public function install($name){
        $dir = '\App\Http\Plugins\\'. $name . '\\' . $name;
        $p = new $dir();
        $res = $p->install(); // 执行安装函数
        return $res;
    }
}
