<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ComponentListener extends Model
{
    //需要让该模型指定对应的表
    public $table = 'component_listeners';

    public function getComponentListener($listened = null,$type = 'listened')
    {
        //type默认是返回监听这个组件的所有组件，如果时handle，返回这个组件监听的所有组件
        // 如果不传参，返回所有
       if(is_null($listened)) return self::all()->toArray();
       // 如果传参，返回监听这个组件的所有组件
        if($type=='listened') return self::where('listened',$listened)->get()->toArray();
        if($type=='handle') return self::where('handle',$listened)->get()->toArray();
        if($type!='listened'&& $type!='handle') throw new \Exception("获取组件监听列表参数错误");
    }

    public function __construct(array $attributes = [])
    {
        self::unguard();
        parent::__construct($attributes);
    }

    // 注册组件监听器
    public function registerComponentListener($listened, $handle, $position = 'before', $async = 0)
    {

        if ($listened == null || $handle == null) throw new \Exception("组件监听器传参错误！");

        $insert = [
            'listened' => $listened,
            'handle' => $handle,
            'position' => $position,
            'async' => $async
        ];

        self::create($insert);
        return true;
    }

    public function removeComponentListener($listened = null, $handle = null)
    {
           //默认移除所有
            if ($listened == null && $handle == null) throw new \Exception("组件监听器传参错误，请输入要删除组件名");
            // 移除被监听组件的所有监听器
//            if ($listened != null && $handle == null) DB::table('ComponentListeners')->where('listened', $listened)->delete();
            if ($listened != null && $handle == null) self::where('listened',$listened)->delete();
            // 移除某个组件监听器，即删除这个组件监听的所有
            if ($listened == null && $handle != null) self::where('handle',$handle)->delete();
             return true;  // 移除成功
    }
}
