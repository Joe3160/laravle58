<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/8/14
 * Time: 13:08
 */

namespace App\Services;


use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserService
{
    //获取权限目录树
    public function getPermissionTree($user_id, $flag,$topTittle=false)
    {
        $result = $this->getPermissionList($user_id, $flag,$topTittle);
        if ($result['code'] !== '0') {
            return $result;
        }
        $permission = $result['data'];
        $tree = getTree($permission, 0, 'sub_menu');
        return dataFormat(0, 'ok', $tree);
    }

    /**
     * 获取权限列表
     * @param $user_id
     * @param bool $flag       是否获取菜单标题
     * @param bool $topTittle  是否只获取第一级菜单
     * @return array
     */
    public function getPermissionList($user_id, $flag = false, $topTittle = false)
    {
        $user = User::find($user_id);
        if (empty($user)) {
            return dataFormat(1, '用户不存在');
        }
        $permission = collect();
        if ($user->is_admin) {//超级管理员
            $permission = Permission::when($flag, function ($query) {
                return $query->where('is_menu', 1);
            })->when($topTittle, function ($query) {
                return $query->where('parent_id', 0);
            })->get();
        } else {
            foreach ($user->roles as $role) {
                $temp = $role->permissions()->when($flag, function ($query) {//只获取权限菜单标题
                    return $query->where('permissions.is_menu', 1);
                })->when($topTittle, function ($query) {
                    return $query->where('permissions.parent_id', 0);
                })->get();
                $permission = $permission->concat($temp);
            }
        }
        $permission = $permission->unique('id')->values()->map(function ($item) {
            return [
                'id'         => $item->id,
                'parent_id'  => $item->parent_id,
                'is_menu'    => $item->is_menu,
                'name'       => $item->name,
                'unique_key' => $item->unique_key,
                'uri'        => $item->uri ? Str::start($item->uri, '/') : '',
            ];
        });
        return dataFormat(0, 'ok', $permission);
    }

    //新增后台用户
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


    //编辑用户信息
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
            $count = User::where([
                ['name', '=', $name],
                ['id', '<>', $id],
            ])->first();
            if (!empty($count)) {
                return dataFormat(1, '用户名已被注册');
            }
            $user->name = $name;
        }
        if ($request->filled('phone')) {
            $phone = $request->input('phone');
            if (!check_mobile($phone)) {
                return dataFormat(1, '手机号码格式不正确');
            }
            $count = User::where([
                ['phone', '=', $phone],
                ['id', '<>', $id],
            ])->first();
            if (!empty($count)) {
                return dataFormat(1, '手机号已被注册');
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
        try {
            DB::beginTransaction();
            $user->roles()->detach();//关联删除
            $bool = $user->delete();
            DB::commit();
            return dataFormat(0, '用户删除成功');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return dataFormat(1, '系统异常');
        }
    }

    //获取用户角色
    public function getRoles(Request $request)
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

    //更新用户角色
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

}