<?php

namespace App\Model;

use App\Http\Moulds\ArticleContentMould\ArticleContentMould;
use App\Libraries\ParseData;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Mould extends Model
{
    protected $table = 'models';

    protected $fillable = [
        'name', 'dir', 'table_name','template_map','description'
    ];

    //生成模型配置文件
    public static function createConfig($table_name,$configs){
        $par = new ParseData();
        return $par->createTable($table_name,$configs);
    }

    public static function getLocalMould(){
        $list = scandir(app_path().'/Http/Moulds');
        $data = []; // 模型数据
        // 剔除无效数据
        foreach ($list as $k => $v){
            if($v=="."||$v==".."||(!is_dir(app_path().'/Http/Moulds/'.$list[$k]))){
                unset($list[$k]);
            } else{
                $dir = '\App\Http\Moulds\\'. $v . '\\' . $v;
                $m = new $dir(); // 动态实例化对象，获取到数据并返回
                $data[] = $m->info;
            }
        }
        foreach ($data as $k => $v){
            $s = Mould::where('dir',$v['dir'])->get()->isEmpty();
            if(!$s){
             $data[$k]['installed'] = 1;
            }
        }
        return $data;
    }

    // 生成模型的json文件，用于表现每个组件的映射
    public static function createJson(){

        $json = [];
        // 遍历模型目录，获取模型组件映射
        $dir = app_path().'/Http/Moulds';
        $dirs = scandir($dir);
        foreach ($dirs as $v){
            if($v == '.'||$v=='..'||$v=='BaseMould.php') continue;
            if($list = scandir($dir.'/'.$v.'/Components')){
                $arr = [];
                foreach ($list as $item){
                    if($item == '.'||$item == '..') continue;
                    $arr[] = $item;
                }
                $json[$v] = $arr;
            }
        }
        // 遍历自定义组件目录，生成所有组件映射
        $custom = scandir(app_path().'/Http/Components');
        foreach ($custom as $v){
            if($v=='.'||$v=='..') continue;
            $json['dev'][] = $v;
        }
        // 更新
        $filepath = public_path().'/components.json';
        if(file_exists($filepath)){
            file_put_contents($filepath,json_encode($json));
        }else{
            $file = fopen($filepath,'w+');
            fwrite($file,json_encode($json));
            fclose($file);
        }
        return $json;
    }

    public static function getInstalledMoulds(){
        $data = Mould::all()->toArray();
        foreach ($data as $k => $v){
            $data[$k]['installed'] = 1;
        }
        return $data;
    }
}
