<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    //权限列表
    public function index(Request $request)
    {
        $page_size = $request->input('page_size', 10);
        $page_size = $page_size > 0 ? $page_size : 0;
        $result = Permission::select('id', 'name', 'remark', 'created_at')->paginate($page_size);
        return dataFormat(0, 'ok', $result);
    }

    //添加权限
    public function add(Request $request)
    {
        $name = $request->input('name');
        $count = Permission::where('name', $name)->first();
        if (!empty($count)) {
            return dataFormat(1, '权限名已经存在!');
        }
        $uri=$request->input('uri');
        $count = Permission::where('uri', $uri)->first();
        if (!empty($count)) {
            return dataFormat(1, '权限地址已经存在!');
        }
        $remark = $request->input('remark');
        $permission = Permission::firstOrNew([
            'name' => $name
        ]);
        $permission->remark = $remark;
        $permission->uri = $uri;
        if ($permission->save()) {
            return dataFormat(0, '权限添加成功');
        }
        return dataFormat(1, '权限添加失败');
    }

    //编辑权限
    public function edit(Request $request)
    {
        $id = $request->input('id');
        if ($id <= 0) {
            return dataFormat(1, '参数无效【ID】');
        }
        $permission = Permission::find($id);
        if (empty($permission)) {
            return dataFormat(1, '权限不存在或已删除');
        }
        if ($request->filled('name')) {
            $permission->name = $request->input('name');
        }
        if ($request->filled('remark')) {
            $permission->remark = $request->input('remark');
        }
        if ($request->filled('uri')) {
            $permission->uri = $request->input('uri');
        }
        if ($permission->save()) {
            return dataFormat(0, '权限更新成功');
        }
        return dataFormat(1, '权限未修改');
    }


    //删除权限
    public function del(Request $request)
    {
        $id = $request->input('id');
        if ($id <= 0) {
            return dataFormat(1, '参数无效【ID】');
        }
        $permission = Permission::find($id);
        if (empty($permission)) {
            return dataFormat(1, '权限不存在或已删除');
        }
        $bool = $permission->delete();
        if ($bool) {
            return dataFormat(0, '权限删除成功');
        }
        return dataFormat(1, '权限删除失败');
    }

}
