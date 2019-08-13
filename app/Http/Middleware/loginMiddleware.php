<?php

namespace App\Http\Middleware;

use Closure;

class loginMiddleware
{
    /**
     * Handle an incoming request.
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->session()->get('user');
        if (empty($user)) {
            return response()->json(dataFormat(110, '请先登陆'));
        }
        //@todo 优化
        //暂无没有办法直接写 $request->user()来获取登陆信息
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        return $next($request);
    }
}
