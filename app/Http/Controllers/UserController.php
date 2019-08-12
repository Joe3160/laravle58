<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    public function add(Request $request)
    {
        $name = $request->input('name');
        $password = $request->input('password');
        $confirm = $request->input('password_confirm');
        $phone = $request->input('phone');
        if (empty($phone)) {
            return dataFormat(1, '手机号码不能为空');
        }
        if (!check_mobile($phone)) {
            return dataFormat(1, '手机号码格式不正确');
        }
        if (empty($password)) {
            return dataFormat(1, '密码不能为空');
        }
        if (empty($confirm)) {
            return dataFormat(1, '确认密码不能为空');
        }
        if ($confirm != $password) {
            return dataFormat(1, '两次密码输入不一致');
        }
        if (empty($name)) {
            return dataFormat(1, '用户名不能为空');
        }
        $user = User::where('phone', $phone)->first();
        if (!empty($user)) {
            return dataFormat(1, '手机号已经被注册');
        }
        $user = User::where('name', $phone)->first();
        if (!empty($user)) {
            return dataFormat(1, '用户名已经被注册');
        }
        $user = new User;
        $user->name = $name;
        $user->phone = $phone;
        //验证用这个：Hash::check('plain-text', $hashedPassword)
        $user->password = Hash::make($password);
        if ($user->save()) {
            return dataFormat(0, '用户新增成功');
        }
        return dataFormat(1, '用户新增失败');
    }

    public function edit(Request $request)
    {
        $id = $request->input('id');
        if ($id <= 0) {
            return dataFormat(1, '参数无效【ID】');
        }
        $user = User::find($id);
        if (empty($user)) {
            return dataFormat(1, '用户不存在或已删除');
        }
        if ($request->filled('name')) {
            $name = $request->input('name');
            if (!check_user_name($name)) {
                return dataFormat(1, '用户格式错误');
            }
            $user->name = $name;
        }
        if ($request->filled('phone')) {
            $phone = $request->input('phone');
            if (!check_mobile($phone)) {
                return dataFormat(1, '手机号码格式不正确');
            }
            $user->phone = $phone;
        }
        if ($user->save()) {
            return dataFormat(0, '用户更新成功');
        }
        return dataFormat(1, '用户未修改');
    }


    public function del(Request $request)
    {
        $id = $request->input('id');
        if ($id <= 0) {
            return dataFormat(1, '参数无效【ID】');
        }
        $user = User::find($id);
        if (empty($user)) {
            return dataFormat(1, '用户不存在或已删除');
        }
        $bool = $user->delete();
        if ($bool) {
            return dataFormat(0, '用户删除成功');
        }
        return dataFormat(1, '用户删除失败');
    }


    //获取所有角色
    public function user_roles()
    {
        

        $roles = Role::select('id', 'name')->all();
        return dataFormat(0, 'ok', $roles);
    }




}
