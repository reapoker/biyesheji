<?php

namespace App\Http\Middleware;

use App\Jobs\AceJob;
use App\Model\ComponentListener;
use Closure;

class BeforeHandleMiddleware
{
    /**
     * 在组件执行之前执行的中间件，用来判断是否有监听该组件的操作
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 查看这个组件在它的模型或者插件中是否关联了事件，关联的是before还是behind
        $cpListener = new ComponentListener();
        $event = $cpListener->getComponentListener($request['name']);
        // 执行before监听事件
        foreach ($event as $k => $v){
            if($v['position']=='before'){
                if($v['async']==0){
                    // 同步执行组件函数
                    // 触发事件
                    $request = handleComponent($v['handle'],$request); // 务必返回一个request对象，不能返回true，false等
                }else{
                    // 触发事件并异步执行
                    // 通过队列异步执行组件函数
                    dispatch(new AceJob($v['handle'],$request));
                }
            }
        }
        return $next($request);
    }
}
