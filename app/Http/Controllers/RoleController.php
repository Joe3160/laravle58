<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class RoleController extends Controller
{
    //角色列表
    public function index(Request $request)
    {
        $page_size = $request->input('page_size', 10);
        $page_size = $page_size > 0 ? $page_size : 0;
        $result = Role::select('id', 'name', 'remark', 'created_at')->paginate($page_size);
        return dataFormat(0, 'ok', $result);
    }

    //添加角色
    public function add(Request $request)
    {
        $name = $request->input('name');
        $count = Role::where('name', $name)->first();
        if (!empty($count)) {
            return dataFormat(1, '角色已经存在!');
        }
        $remark = $request->input('remark');
        $role = Role::firstOrNew([
            'name' => $name
        ]);
        $role->name = $name;
        $role->remark = $remark;
        if ($role->save()) {
            return dataFormat(0, '角色添加成功');
        }
        return dataFormat(1, '角色添加失败');
    }

    //删除角色
    public function del(Request $request)
    {
        $id = $request->input('id');
        if ($id <= 0) {
            return dataFormat(1, '参数无效【ID】');
        }
        $role = Role::find($id);
        if (empty($role)) {
            return dataFormat(1, '角色不存在或已删除');
        }
        $bool = $role->delete();
        if ($bool) {
            return dataFormat(0, '角色删除成功');
        }
        return dataFormat(1, '角色删除失败');
    }

    //更新角色
    public function edit(Request $request)
    {
        $id = $request->input('id');
        if ($id <= 0) {
            return dataFormat(1, '参数无效【ID】');
        }
        $role = Role::find($id);
        if (empty($role)) {
            return dataFormat(1, '角色不存在或已删除');
        }
        if ($request->filled('name')) {
            $role->name = $request->input('name');
        }
        if ($request->filled('remark')) {
            $role->remark = $request->input('remark');
        }
        if ($role->save()) {
            return dataFormat(0, '角色更新成功');
        }
        return dataFormat(1, '角色未修改');
    }

    //获取角色的权限
    public function permission(Request $request)
    {
        $role_id = $request->input('role_id');
        if ($role_id <= 0) {
            return dataFormat(1, '参数错误[ROLE_ID]');
        }
        $role = Role::find($role_id);
        if (empty($role)) {
            return dataFormat(1, '角色不存在或已删除');
        }
        $had=[];
        foreach ($role->permissions as $permission) {
            $had[$permission->id]=$permission->id;
        }
        $permissions=Permission::all();
        $result=[];
        foreach ($permissions as $permission) {
            $result[] = [
                'permission_id'   => $permission->id,
                'permission_name' => $permission->name,
                'is_had'    => isset($had[$permission->id]) ? 1 : 0,
            ];
        }
        return dataFormat(0, 'ok', $result);

    }

    //同步角色的权限
    public function sync_permission(Request $request)
    {
        $role_id = $request->input('role_id');
        if ($role_id <= 0) {
            return dataFormat(1, '参数错误[ROLE_ID]');
        }
        $arr = $request->input('permission_ids');
        if (!is_array($arr)) {
            return dataFormat(1, '参数错误[PERMISSION_IDS]');
        }
        $arr = array_unique($arr);
        $arr = Arr::where($arr, function ($value, $key) {
            return $value > 0;
        });
        if (empty($arr)) {
            return dataFormat(1, '参数无效[PERMISSION_IDS]');
        }
        $permission_ids = Permission::whereIn('id', $arr)->pluck('id');
        if ($permission_ids->isEmpty()) {
            return dataFormat(2, '参数无效[PERMISSION_IDS]');
        }
        $role = Role::find($role_id);
        if (empty($role)) {
            return dataFormat(1, '权限不存在或已删除');
        }
        $result =$role->permissions()->sync($permission_ids);
        // dump($result);
        return dataFormat(0, 'ok');
    }




}
