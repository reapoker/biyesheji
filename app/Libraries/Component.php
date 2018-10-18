<?php
/**
 * Created by PhpStorm.
 * User: silsuer
 * Date: 2018/1/31
 * Time: 13:57
 */

namespace App\Libraries;

//用来操作组件
use App\Model\Mould;
use Mockery\Exception;

class Component
{
    public $path;
    public $components = [];

    public function __construct()
    {
        $this->path = public_path() . '/components.json'; //初始化文件
        if (file_exists($this->path)) {
            $content = file_get_contents($this->path);
            $c = json_decode($content);
            foreach ($c as $k => $v) {
                if (!is_array($v)) {
                    $c[$k] = $this->toArray($v);
                }
            }
            $this->components = $c;
        } else {
            throw new \Exception("组件树文件不存在！");
        }
    }

    // 注册组件
    public function register($arr)
    {
        if (array_key_exists($arr['name'], $this->components)) {
            throw new \Exception("该组件已存在，请重新设置！");
        }
        $c['name'] = $arr['name'];
        $c['status'] = 'enable';
        $c['type'] = $arr['type'];
        $c['description'] = $arr['description'];
        if ($arr['model_id'] != 0) {
            $mould = Mould::find($arr['model_id']);
            $c['belongTo'] = $mould->dir; // 获取所属模型
            $p = app()->path() . '/Http/Moulds/' . $mould->dir . '/Components/' . $arr['name'];
        } else {
            $c['belongTo'] = 'dev';  //如果是0的话，添加到自定义组件
            $p = app()->path() . '/Http/Components/' . $arr['name'];
        }
        if (!file_exists($p)) {
            mkdir($p, 0777, true); // 组件文件夹不存在，就尝试创建
        }

        //开始添加文件
        $des = ["type" => $c['type'], "description" => $c['description']];
        $file = fopen($p . '/description.txt', 'w+');
        fwrite($file, json_encode($des));
        fclose($file);

        $file = fopen($p . '/' . $arr['name'] . '.php', 'w+');
        fwrite($file, $arr['php_code']);
        fclose($file);


        $file = fopen($p . '/' . $arr['name'] . '.js', 'w+');
        fwrite($file, $arr['js_code']);
        fclose($file);
        // 写入成功

        $this->components[] = $c;
        file_put_contents($this->path, json_encode($this->components));
        return $this->components; // 注册成功，返回注册的组件

    }
    //TODO 删除组件
    // 重新渲染组件树
    public function renderComponentsJson()
    {
        // 转移模型文件夹下的js文件
        $ll = scandir(app()->path() . '/Http/Moulds/');
        foreach ($ll as $l) {
            if ($l == '.' || $l == '..' || strpos($l, '.php')) continue;
            move_to_components($l);
        }


        // 转移自定义组件下的js文件
        move_dev_components();

        // 转移插件下的js文件
        $ll2 = scandir(app()->path() . '/Http/Plugins/');
        foreach ($ll2 as $l2) {
            if ($l2 == '.' || $l2 == '..' || strpos($l2, '.php')) continue;
            move_plugins_components($l2);
        }


        // 先添加所有模型下的组件
        $this->components = []; //清空数据
        $dir = app()->path() . '/Http/Moulds';
        $dirs = scandir($dir); // 得到所有模型列表
        foreach ($dirs as $v) {
            if ($v == '.' || $v == '..' || $v == 'BaseMould.php') continue;
            if ($list = scandir($dir . '/' . $v . '/Components')) {
                $arr = [];
                foreach ($list as $item) {
                    if ($item == '.' || $item == '..') continue;
                    $p = $dir . '/' . $v . '/Components/' . $item . '/description.txt';
                    $arr['name'] = $item;
                    $arr['status'] = 'enable';
                    $arr['belongTo'] = $v;
                    if (file_exists($p)) {
                        $content = file_get_contents($p);
                        $des = json_decode($content);
                        if (is_object($des)) {
                            $des = $this->toArray($des);
                        }
                        $arr['type'] = $des['type'];
                        $arr['description'] = $des['description']; //写入description

                    }
                    $this->components[] = $arr;
                }
            }
        }

        // 在添加所有自定义组件
        $custom = scandir(app()->path() . '/Http/Components');
        foreach ($custom as $v) {
            if ($v == '.' || $v == '..') continue;
            $p = app()->path() . '/Http/Components/' . $v . '/description.txt';
            $arr['name'] = $v;
            $arr['status'] = 'enable';
            $arr['belongTo'] = 'dev';
            if (file_exists($p)) {
                $content = file_get_contents($p);
                $des = json_decode($content);
                $des = $this->toArray($des);
                $arr['type'] = $des['type'];
                $arr['description'] = $des['description'];
            }
            $this->components[] = $arr;
        }

        // 添加插件下的所有组件
        $dir = app()->path() . '/Http/Plugins';
        $dirs = scandir($dir); // 得到所有模型列表
        foreach ($dirs as $v) {
            if ($v == '.' || $v == '..' || $v == 'BasePlugins.php') continue;
            if ($list = scandir($dir . '/' . $v . '/Components')) {
                $arr = [];
                foreach ($list as $item) {
                    if ($item == '.' || $item == '..') continue;
                    $p = $dir . '/' . $v . '/Components/' . $item . '/description.txt';
                    $arr['name'] = $item;
                    $arr['status'] = 'enable';
                    $arr['belongTo'] = $v;
                    if (file_exists($p)) {
                        $content = file_get_contents($p);
                        $des = json_decode($content);
                        if (is_array($des)) {
                            $arr['type'] = $des['type'];
                            $arr['description'] = $des['description']; //写入description
                        } else {
                            $arr['type'] = $des->type;
                            $arr['description'] = $des->description;
                        }


                    }
                    $this->components[] = $arr;
                }
            }
        }

        file_put_contents($this->path, json_encode($this->components)); // 写入文件
        return $this->components; //返回当前的组件数组
    }

    public function renderSingleComponent($name)
    {
        $p_path = $this->getAppJsPath($name); // 获取在app/Http下的路径
        $j_path = $this->getPublicJsPath($name); // 获取在public/js下的路径
        file_put_contents($j_path,file_get_contents($p_path)); // 内容同步
        return true;
    }

    public function getAppJsPath($name){
        // 获取这个组件在app/Http目录下的js文件的路径
        $path =  $this->getPath($name);
        $parr = explode('.',$path);
        array_pop($parr); // 删除最后一个
        $p = '';
        foreach ($parr as $v){
            $p .= $v . '.';
        }

        $p = substr($p, 0, -1) . '.js';
        if(file_exists($p)) return $p;
        dd("组件 " . $name . " 在 /app/Http/ 下的js文件不存在");
    }


    public function getPublicJsPath($name)
    {
        // 获取到这个组件在public/js下的js文件路径
        foreach ($this->components as $v) {
            if ($v['name'] == $name) {
                // 获取到js目录下的地址
                $p = public_path() . '/js/components/' . $v['belongTo'] . '/' . $name . '/' . $name . '.js';
                if (file_exists($p)) return $p;
                dd("组件 " . $name . " 在/public/js/components/" . $v['belongTo'] . "下的js文件不存在！");
            }
        }
    }

    // 获取全部可用组件
    public function getComponentsList()
    {
        return $this->components; //返回所有组件
    }


    // 获取组件路径
    public function getPath($name, $filename = true)
    {
        $exist = 0;
        $arr = [];
        foreach ($this->components as $k => $v) {
            if (isset($v['name']) && $name == $v['name']) {
                $exist = 1; // 组件存在
                $arr = $this->toArray($v);
            }
        }
//        dd($this->components);
        // 根据传入的组件名，获取组件的php文件所在路径，并且判断这个文件是否存在，存在，返回路径，不存在，返回false
        if ($exist) { // 组件存在
            if ($arr['belongTo'] == 'dev') {
                // 如果是自定义组件
                $p = app()->path() . '/Http/Components/' . $name . '/' . $name . '.php';
            } else {
                $p = app()->path() . '/Http/Moulds/' . $arr['belongTo'] . '/Components/' . $name . '/' . $name . '.php';
                if (!file_exists($p)) {
                    $p = app()->path() . '/Http/Plugins/' . $arr['belongTo'] . '/Components/' . $name . '/' . $name . '.php';
                }
            }

            if (file_exists($p)) { // 如果存在，就返回这个路径，如果不存在，返回false;
                if ($filename) {
                    return $p;
                } else {
                    return substr($p, 0, strlen($p) - strlen($name . '.php'));
                }

            } else {
                return false;
            }
        } else {
            return false; // 组件不存在
        }

    }

    public function get($name)
    {
        $tmp = [];
        foreach ($this->components as $k => $v) {
            if (isset($v['name']) && $name == $v['name']) {
                $tmp = $this->toArray($v);
                $p = $this->getPath($tmp['name'], false);// 获得php文件的路径,第二个参数，证明到目录
                $tmp['php_code'] = file_get_contents($p . $name . '.php');
                $tmp['js_code'] = file_get_contents($p . $name . '.js');
                return $tmp;
            }
        }

        return false;
    }

    public function remove($name)
    {
        if (!$name) {
            throw new \Exception("缺少参数！");
        }

        $component = $this->get($name);
        if ($component['belongTo'] == 'dev') {  // 自定义组件
            $res = rmdirs(app()->path() . '/Http/Components/' . $name);
        } else {  // 模型定义组件
            $res = rmdirs(app()->path() . '/Http/Moulds/' . $component['belongTo'] . '/Components/' . $name);
        }
        $this->renderComponentsJson(); //删除完成后重新渲染组件
        return $res;
    }

    public function toArray($obj)
    {
        return json_decode(json_encode($obj), true);
    }

    public function handle($name, $arr)
    {

    }
}