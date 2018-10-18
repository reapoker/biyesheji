<?php
/**
 * Created by PhpStorm.
 * User: liuho
 * Date: 2018/2/25
 * Time: 10:05
 */

namespace App\Http\Plugins\ThemesManager;


use App\Http\Plugins\BasePlugins;

class ThemesManager extends BasePlugins
{
    public $path;
    public $dirs;
    public $themes;

    public $info = [
        'name' => '主题管理',
        'dir' => 'ThemesManager',
        'description' => '主题管理插件，把主题放置在public目录下'
    ];

    public $template_map = [
        'index' => [
            'name'=> '主题管理',
            'template' => 'index.html'
        ]
    ] ;

    public function __construct()
    {

        $this->path =  app_path() . "/Http/Themes/";
        $this->dirs =  scandir($this->path);
        $list = [];
        foreach ($this->dirs as $v){
            if($v=='.'||$v=='..') continue;
            $theme['name'] = $v;
            $pp = $this->path. $v . '/description.json';
            if(file_exists($pp)){
                $contents = file_get_contents($pp);
                $des = json_decode($contents,true);
                $list[] = $des;
            }
            $this->themes = $list;
        }
    }

    public function getList(){
        return $this->themes;
    }

    public function setupTheme($dir){
        foreach ($this->themes as $v){
            if($v['dir']==$dir){
                $sources = $this->path . $dir;
                $dest = public_path() . '/theme';
                // 开始复制这里的数据
                copydir($sources,$dest);
                $index_path = $sources . '/index.html';
                if(file_exists($index_path)){
                    $contents = file_get_contents($index_path);
                    $file = fopen(public_path().'/index.html',"w+");
                    fwrite($file,$contents);
                    fclose($file);
                }
            }
        }
        return true;
    }
}