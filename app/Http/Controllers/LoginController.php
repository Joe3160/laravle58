<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    //登陆
    public function login(Request $request)
    {
        if (!empty(session('user'))) {
            return dataFormat(0, '您已登陆');
        }
        $name = $request->input('user_name');
        $password = $request->input('password');
        if (empty($name) || empty($password)) {
            return dataFormat(1, '用户名及密码不能为空');
        }
        $user = User::when(check_mobile($name), function ($query) use ($name) {
            return $query->where('phone', $name);
        }, function ($query) use ($name) {
            return $query->where('name', $name);
        })->first();
        if (empty($user)) {
            return dataFormat(1, '帐号或密码不正确');
        }
        if (!Hash::check($password, $user->password)) {
            return dataFormat(2, '帐号或密码不正确');
        }
        $user->last_login_time = now();
        $user->remember_token = uniqid();
        $user->save();
        session(['user' => $user]);
        session('user');
        //@todo 优化
        //使之可以能通过 $requst->user()来获取用户信息
        // $request->setUserResolver(function () use ($user) {
        //     return $user;
        // });
        return dataFormat(0, '登陆成功');
    }

    //退出
    public function logout(Request $request)
    {
        // $request->session()->forget('user');//删除特定key的session
        $request->session()->flush();//删除所有session
        return dataFormat(0, '您已退出');

    }
}
