<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
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
    public function roles(Request $request)
    {
        // $user = $request->user();
        $user_id = $request->input('user_id');
        if ($user_id <= 0) {
            return dataFormat(1, '参数错误[USER_ID]');
        }
        $user = User::find($user_id);
        if (empty($user)) {
            return dataFormat(1, '用户不存在或已删除');
        }
        $had = [];
        foreach ($user->roles as $role) {
            $had[$role->id] = $role->id;
        }
        $roles = Role::all();
        $result = [];
        foreach ($roles as $role) {
            $result[] = [
                'role_id'   => $role->id,
                'role_name' => $role->name,
                'is_had'    => isset($had[$role->id]) ? 1 : 0,
            ];
        }
        return dataFormat(0, 'ok', $result);
        // $result = DB::table('roles AS p1')->select('p1.id AS role_id', 'p1.name AS role_name', 'p3.id AS user_id')->leftJoin('role_user AS p2', 'p1.id', '=', 'p2.role_id')->leftJoin('users AS p3', function ($join) use ($user) {
        //     return $join->on('p3.id', '=', 'p2.user_id')->where('p3.id', '=', $user->id)->whereNull('p3.deleted_at');
        // })->whereNull('p1.deleted_at')->groupBy('p1.id')->get();
        // return dataFormat(0, 'ok', $result);
    }

    //同步并设置用户角色
    public function sync_roles(Request $request)
    {
        // $user = $request->user();
        $user_id = $request->input('user_id');
        if ($user_id <= 0) {
            return dataFormat(1, '参数错误[USER_ID]');
        }
        $arr = $request->input('role_ids');
        if (!is_array($arr)) {
            return dataFormat(1, '参数错误[ROLE_IDS]');
        }
        $arr = array_unique($arr);
        $arr = Arr::where($arr, function ($value, $key) {
            return $value > 0;
        });
        if (empty($arr)) {
            return dataFormat(1, '参数无效[ROLE_IDS]');
        }
        $roles_ids = Role::whereIn('id', $arr)->pluck('id');
        if ($roles_ids->isEmpty()) {
            return dataFormat(2, '参数无效[ROLE_IDS]');
        }
        $user = User::find($user_id);
        if (empty($user)) {
            return dataFormat(1, '用户不存在或已删除');
        }
        $result = $user->roles()->sync($roles_ids);
        return dataFormat(0, 'ok');
    }

    //获取当前登陆用户权限
    public function permission(Request $request, UserService $userService)
    {
        $userSession = $request->user();
        $user = User::find($userSession->id);//同个模型实例为何$userSession取不出关联关系
        $result = $userService->getPermission($user);
        return $result;
    }


}
