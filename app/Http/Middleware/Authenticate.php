<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // 开发的时候打开这一行，避免始终要进行验证
        return $next($request);
//        dd($request->all());
        // 如果是注册和登录组件，不经过中间件
        if($request->name == 'admin_login'||$request->name == 'admin_register') return $next($request);
        if ($this->auth->guard($guard)->guest()) {
            return response('Unauthorized', 401);
        }

        return $next($request);
    }
}
