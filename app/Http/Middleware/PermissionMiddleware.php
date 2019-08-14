<?php

namespace App\Http\Middleware;

use App\Services\UserService;
use Closure;
use Illuminate\Support\Arr;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();
        if ($user->is_admin == 1) {//超级管理员
            return $next($request);
        }
        $userService=new UserService;
        $result=$userService->getPermissionList($user->id);
        if ($result['code'] !== '0') {
            return response()->json($result);
        }
        $path=$request->path();
        $data = $result['data'];
        $first=Arr::first($data, function ($value, $key) use ($path) {
            return $value['uri']==$path;
        });
        if (empty($first)) {
            return response()->json(dataFormat(100,'无权访问'));
        }
        return $next($request);
    }
}
