<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function index(Request $request)
    {
        $page_size = $request->input('page_size', 10);
        $page_size = $page_size > 0 ? $page_size : 0;
        $result = User::select('id', 'name', 'phone', 'created_at')->paginate($page_size);
        return dataFormat(0, 'ok', $result);
    }

    //新增用户
    public function add(Request $request, UserService $service)
    {
        $result = $service->add($request);
        return $result;
    }

    //编辑用户信息
    public function edit(Request $request, UserService $service)
    {
        $result = $service->edit($request);
        return $result;
    }


    //删除用户
    public function del(Request $request, UserService $service)
    {
        $result = $service->del($request);
        return $result;
    }

    //获取所有角色
    public function roles(Request $request, UserService $service)
    {
        $result = $service->getRoles($request);
        return $result;
    }

    //设置用户角色
    public function sync_roles(Request $request, UserService $service)
    {
        $result = $service->sync_roles($request);
        return $result;
    }

    //获取当前登陆用户权限
    public function permission(Request $request, UserService $userService)
    {
        $userSession = $request->user();
        $result = $userService->getPermissionTree($userSession->id, true);
        // dump($result);
        return $result;
    }


}
