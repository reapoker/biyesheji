<?php
/**
 * Created by PhpStorm.
 * 自定义一些需要得函数
 * User: silsuer
 * Date: 2018/1/4
 * Time: 22:05
 */


//function getComponentListener($listened=null){
//    if(is_null($listened)) return DB::table('ComponentListeners')->get()->toArray();
//    return DB::table('ComponentListeners')->where('listened',$listened)->get()->toArray();
//}
//
//
//// 注册组件监听器
//function registerComponentListener($listened,$handle,$position = 'behind',$async = 0){
//
//    if($listened==null||$handle==null) throw new \Exception("组件监听器传参错误！");
//
//    $insert = [
//        'listened'=>$listened,
//        'handle'=>$handle,
//        'position'=>$position,
//        'async'=>$async
//    ];
//
//    DB::table('ComponentListeners')->insert($insert);  // 插入监听器
//
//    return true;
//}
//
//function removeComponentListener($listened =null ,$handle =null){
//    //默认移除所有
//    if($listened==null&&$handle==null) throw new \Exception("组件监听器传参错误，请输入要删除组件名")
//    // 移除被监听组件的所有监听器
//    if ($listened!=null&&$handle==null) DB::table('ComponentListeners')->where('listened',$listened)->delete();
//    // 移除某个组件监听器，即删除这个组件监听的所有
//    if($listened==null &&$handle!=null) DB::table('ComponentListeners')->where('handle',$handle)->delete();
//    return true;  // 移除成功
//}


function obj_to_array($obj)
{
    if (is_object($obj)) {
        return json_decode(json_encode($obj), true);
    }
    return $obj;
}

function isEmail($str)
{
    if (filter_var($str, FILTER_VALIDATE_EMAIL, FILTER_FLAG_PATH_REQUIRED)) {
        return true;
    } else {
        return false;
    }
}

/**
 * @param $data 要返回的数据
 * @param string $info 返回自定义提示信息
 * @param int $status 状态码
 */
function responseSuccessed($data = null, $info = 'Successed!', $status = 200)
{
    $response = [
        'status' => $status,
        'data' => $data,
        'info' => $info,
    ];

    return response()->json($response, $status);
}

function responseFailed($data = null, $info = 'Failed!', $status = 500)
{
    $response = [
        'status' => $status,
        'data' => $data,
        'info' => $info,
    ];

    return response()->json($response, $status);
}

function mould_path($name = null)
{
    // 如果传入了名字，就返回这个模型名称的路径，如果传入为空，就返回模型所在目录
    return $name ? '\App\Http\Moulds\\' . $name . '\\' . $name : '\App\Http\Moulds\\';
}

function getSingleName()
{
    // 获取一个不重复的方法名，并返回，等待替换
    $str = "QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm";
    str_shuffle($str);
    $name = substr(str_shuffle($str), 0, 10);
    if (function_exists($name)) $name = getSingleName();
    return $name;
}


/*
 * 组件执行函数
 * 为了使组件间可以通信，即一个组件获取另一个组件的逻辑处理返回值，那么由于每个组件的函数名都叫handle，导致函数命名冲突
 * 这里引入了一个名字叫做aceberg的自定义封装协议，用来给函数重命名成一个名字长度为10位的随机字符，然后执行后返回
 */
function handleComponent($name, $attr)
{
    // 如果是组件调用组件的话，会遇到handle函数冲突，此处需要重命名函数
//    rename_function 这个函数属于runkit扩展中，需要自行编译，并且官方不支持php7，因此放弃
//    if(function_exists('handle')) renameHandle();
        // 获取一个不重复的随机函数名
        $func_name = getSingleName();
        // 实例化一个协议，这个协议的构造函数中注册了该协议
        new \App\Libraries\ComponentProtocol();
        // 使用协议，传入以 . 号分割的一个字符串，分别是，组件名 和 生成的随机函数名
        include('aceberg://' . $name . '.' . $func_name);
        if (function_exists($func_name)) {
            return $func_name($attr);
        } else {
            throw new \Exception("handle方法不存在！:$name:$path");
        }
}


function move_to_components($name)
{
    if (!$name) {
        throw new \Exception("请输入模型名称");
    }
    $sources = app()->path() . '/Http/Moulds/' . $name . '/Components';
    $dest = public_path() . '/js/components/' . $name . '/';
    if (is_dir($dest)) {
        rmdirs($dest); // 如果这个模型文件夹存在，清空文件夹
    }
    if (is_dir($sources)) {
        copydir($sources, $dest);
    } else {
        mkdir($sources, 0777, true);
//        throw new \Exception("模型下没有组件目录:" . $sources);
    }
    return true;
}

function move_dev_components()
{
    $sources = app()->path() . '/Http/Components';
    $dest = public_path() . '/js/components/dev';
    if (is_dir($dest)) {
        rmdirs($dest); // 如果这个模型文件夹存在，清空文件夹
    }
    if (is_dir($sources)) {
        copydir($sources, $dest);
    } else {
        mkdir($sources, 0777, true);
//        throw new \Exception("dev下没有组件目录:" . $sources);
    }
}

function move_plugins_components($name)
{
    // 传入插件名称
    if (!$name) {
        throw new \Exception("请输入插件名称");
    }
    $sources = app()->path() . '/Http/Plugins/' . $name . '/Components';
    $dest = public_path() . '/js/components/' . $name . '/';
    if (is_dir($dest)) {
        rmdirs($dest); // 如果这个模型文件夹存在，清空文件夹
    }
    if (is_dir($sources)) {
        copydir($sources, $dest);
    } else {
        mkdir($sources, 0777, true);
//        throw new \Exception("插件下没有组件目录:" . $sources);
    }
    return true;
}


/**
 * 判断文件夹大小
 * @param $path
 * @return int
 */
function dirsize($path)
{
    $size = 0;
    $handle = opendir($path);
    while (($item = readdir($handle)) !== false) {
        if ($item == '.' || $item == '..') continue;
        $_path = $path . '/' . $item;
        if (is_file($_path)) $size += filesize($_path);
        if (is_dir($_path)) $size += dirsize($_path);
    }
    closedir($handle);
    return $size;
}

/**
 * 复制文件夹
 * @param $source
 * @param $dest
 */
function copydir($source, $dest)
{
    if (!file_exists($dest)) mkdir($dest, 0777, true);
    $handle = opendir($source);
    while (($item = readdir($handle)) !== false) {
        if ($item == '.' || $item == '..' || strpos($item, '.php') || strpos($item, '.txt')) continue;
        $_source = $source . '/' . $item;
        $_dest = $dest . '/' . $item;
        if (is_file($_source)) copy($_source, $_dest);
        if (is_dir($_source)) copydir($_source, $_dest);
    }
    closedir($handle);
}

/**
 * 删除文件夹
 * @param $path
 * @return bool
 */
function rmdirs($path)
{
    $handle = opendir($path);
    while (($item = readdir($handle)) !== false) {
        if ($item == '.' || $item == '..') continue;
        $_path = $path . '/' . $item;
        if (is_file($_path)) unlink($_path);
        if (is_dir($_path)) rmdirs($_path);
    }
    closedir($handle);
    return rmdir($path);
}


/**
 * 剪切文件夹使用rename
 * rename 是 PHP Filesystem 函数中的一个特例，它既可以重命名文件，也可以重命名文件夹。如果你为重命名文件传入不同的路径，它又成了剪切函数，堪称文件函数中小而美的典范。
 * @param $path
 * @return bool
 */


/*
 * lumen中沒有laravel中的一些辅助函数，这里重新添加上这些函数
 */

if (!function_exists('config_path')) {
    /**
     * Return the path to config files
     * @param null $path
     * @return string
     */
    function config_path($path = null)
    {
        return app()->getConfigurationPath(rtrim($path, ".php"));
    }
}
if (!function_exists('public_path')) {
    /**
     * Return the path to public dir
     * @param null $path
     * @return string
     */
    function public_path($path = null)
    {
        return rtrim(app()->basePath('public/' . $path), '/');
    }
}
if (!function_exists('storage_path')) {
    /**
     * Return the path to storage dir
     * @param null $path
     * @return string
     */
    function storage_path($path = null)
    {
        return app()->storagePath($path);
    }
}
if (!function_exists('database_path')) {
    /**
     * Return the path to database dir
     * @param null $path
     * @return string
     */
    function database_path($path = null)
    {
        return app()->databasePath($path);
    }
}
if (!function_exists('resource_path')) {
    /**
     * Return the path to resource dir
     * @param null $path
     * @return string
     */
    function resource_path($path = null)
    {
        return app()->resourcePath($path);
    }
}
if (!function_exists('lang_path')) {
    /**
     * Return the path to lang dir
     * @param null $str
     * @return string
     */
    function lang_path($path = null)
    {
        return app()->getLanguagePath($path);
    }
}
if (!function_exists('asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string $path
     * @param  bool $secure
     * @return string
     */
    function asset($path, $secure = null)
    {
        return app('url')->asset($path, $secure);
    }
}
if (!function_exists('elixir')) {
    /**
     * Get the path to a versioned Elixir file.
     *
     * @param  string $file
     * @return string
     */
    function elixir($file)
    {
        static $manifest = null;
        if (is_null($manifest)) {
            $manifest = json_decode(file_get_contents(public_path() . '/build/rev-manifest.json'), true);
        }
        if (isset($manifest[$file])) {
            return '/build/' . $manifest[$file];
        }
        throw new InvalidArgumentException("File {$file} not defined in asset manifest.");
    }
}
if (!function_exists('auth')) {
    /**
     * Get the available auth instance.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    function auth()
    {
        return app('Illuminate\Contracts\Auth\Guard');
    }
}
if (!function_exists('bcrypt')) {
    /**
     * Hash the given value.
     *
     * @param  string $value
     * @param  array $options
     * @return string
     */
    function bcrypt($value, $options = array())
    {
        return app('hash')->make($value, $options);
    }
}
if (!function_exists('redirect')) {
    /**
     * Get an instance of the redirector.
     *
     * @param  string|null $to
     * @param  int $status
     * @param  array $headers
     * @param  bool $secure
     * @return \Illuminate\Redirector|\Illuminate\Http\RedirectResponse
     */
    function redirect($to = null, $status = 302, $headers = array(), $secure = null)
    {
        if (is_null($to)) return app('redirect');
        return app('redirect')->to($to, $status, $headers, $secure);
    }
}
if (!function_exists('response')) {
    /**
     * Return a new response from the application.
     *
     * @param  string $content
     * @param  int $status
     * @param  array $headers
     * @return \Symfony\Component\HttpFoundation\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    function response($content = '', $status = 200, array $headers = array())
    {
        $factory = app('Illuminate\Contracts\Routing\ResponseFactory');
        if (func_num_args() === 0) {
            return $factory;
        }
        return $factory->make($content, $status, $headers);
    }
}
if (!function_exists('secure_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string $path
     * @return string
     */
    function secure_asset($path)
    {
        return asset($path, true);
    }
}
if (!function_exists('secure_url')) {
    /**
     * Generate a HTTPS url for the application.
     *
     * @param  string $path
     * @param  mixed $parameters
     * @return string
     */
    function secure_url($path, $parameters = array())
    {
        return url($path, $parameters, true);
    }
}
if (!function_exists('session')) {
    /**
     * Get / set the specified session value.
     *
     * If an array is passed as the key, we will assume you want to set an array of values.
     *
     * @param  array|string $key
     * @param  mixed $default
     * @return mixed
     */
    function session($key = null, $default = null)
    {
        if (is_null($key)) return app('session');
        if (is_array($key)) return app('session')->put($key);
        return app('session')->get($key, $default);
    }
}
if (!function_exists('cookie')) {
    /**
     * Create a new cookie instance.
     *
     * @param  string $name
     * @param  string $value
     * @param  int $minutes
     * @param  string $path
     * @param  string $domain
     * @param  bool $secure
     * @param  bool $httpOnly
     * @return \Symfony\Component\HttpFoundation\Cookie
     */
    function cookie($name = null, $value = null, $minutes = 0, $path = null, $domain = null, $secure = false, $httpOnly = true)
    {
        $cookie = app('Illuminate\Contracts\Cookie\Factory');
        if (is_null($name)) {
            return $cookie;
        }
        return $cookie->make($name, $value, $minutes, $path, $domain, $secure, $httpOnly);
    }
}

if (!function_exists('app_path')) {
    /* 替换常用的 app_path */
    function app_path()
    {
        return app()->path();
    }
}

if (!function_exists('route_parameter')) {
    /**
     * Get a given parameter from the route.
     *
     * @param $name
     * @param null $default
     * @return mixed
     */
    function route_parameter($name, $default = null)
    {
        $routeInfo = app('request')->route();

        return array_get($routeInfo[2], $name, $default);
    }
}


// 数据返回
function statusReturn($res)
{

    /*
     * return "操作成功"
     * return ["操作成功",true]
     * return ["操作成功"， false]
     * return array[]
     * return array[array(),ture/false]
     * return */

    if (is_string($res)) {
        return responseSuccessed(null, $res);
    }

    if(is_bool($res)){
        if($res){
            return responseSuccessed();
        }else{
            return responseFailed();
        }
    }


    if (is_array($res) || is_object($res)) {
        $res = all_to_array($res); // 全部转换为数组
        if (count($res) == 2 && array_key_exists(0, $res) && array_key_exists(1, $res)) {
            if (is_string($res[0]) && is_bool($res[1])) {
                if ($res[1]) {
                    return responseSuccessed(null, $res[0]);
                } else {
                    return responseFailed(null, $res[0]);
                }
            } else if (is_array($res[0] && is_bool($res[1]))) {
                if ($res[1]) {
                    return responseSuccessed($res[0]);
                } else {
                    return responseFailed($res[0]);
                }
            }
        }
        if (count($res) == 3 && array_key_exists(0, $res) && array_key_exists(1, $res) && array_key_exists(2, $res) && is_array($res[0]) && is_string($res[1]) && is_bool($res[2])) {
            if ($res[2]) {
                return responseSuccessed($res[0], $res[1]);
            } else {
                return responseFailed($res[0], $res[1]);
            }
        }

    }

    if (is_array($res) && empty($res)) {
        return responseSuccessed();
    }


    if ($res) {
        return responseSuccessed($res);
    } else {
        return responseFailed();
    }
}


function all_to_array($obj)
{
    if (is_object($obj)) {
        $obj = obj_to_array($obj);
    }
    if (is_array($obj)) {
        foreach ($obj as $k => $v) {
            if (is_object($v)) $obj[$k] = all_to_array($obj[$k]);
        }
    }
    return $obj;
}

if (!function_exists('config_path')) {
    /* Get the configuration path. @param string $path @return string */
    function config_path($path = '') {
        return app()->basePath() . '/config' . ($path ? '/' . $path : $path);
    }
}