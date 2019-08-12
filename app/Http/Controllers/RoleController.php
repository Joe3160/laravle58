<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

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




}
