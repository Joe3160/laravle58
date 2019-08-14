<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        if (empty($name)) {
            return dataFormat(1, '权限名不能为空');
        }
        $count = Permission::where('name', $name)->first();
        if (!empty($count)) {
            return dataFormat(1, '权限名已经存在!');
        }
        $unique_key = $request->input('unique_key');
        if (!$unique_key) {
            return dataFormat(1, '权限名不能为空');
        }
        $count = Permission::where([
            ['unique_key', $unique_key],
        ])->first();
        if (!empty($count)) {
            return dataFormat(1, '权限标识已经存在!');
        }
        $parent_id = (int)$request->input('parent_id');
        if ($parent_id < 0 || $parent_id > 0 && !Permission::find($parent_id)) {
            return dataFormat(1, '权限上级菜单无效');
        }
        $remark = $request->input('remark');
        $permission = Permission::firstOrNew([
            'name' => $name
        ]);
        $permission->unique_key = $unique_key;
        $permission->uri = ltrim($request->input('uri'));
        $permission->remark = $remark;
        $permission->parent_id = $parent_id;
        $permission->is_menu = (int)$request->input('is_menu');
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
        if ($request->filled('parent_id')) {
            $parent_id = (int)$request->input('parent_id');
            if ($parent_id < 0 || $parent_id > 0 && !Permission::find($parent_id)) {
                return dataFormat(1, '权限上级菜单无效');
            }
            $permission->parent_id = $parent_id;
        }
        if ($request->filled('unique_key')) {
            $unique_key = $request->input('unique_key');
            $count = Permission::where([
                ['unique_key', '=', $unique_key],
                ['id', '<>', $permission->id],
            ])->first();
            if ($count) {
                return dataFormat(1, '权限标识已存在');
            }
            $permission->unique_key = $unique_key;
        }
        if ($request->filled('is_menu')) {
            $permission->is_menu = $request->input('is_menu') ? 1 : 0;
        }
        if ($request->filled('uri')) {
            $permission->uri = ltrim($request->input('uri'), '/');
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
        $roles=$permission->has('roles')->get();
        if ($roles->isNotEmpty()) {
            $first=$roles->first();
            return dataFormat(1, '权限已分配给角色【'.$first->name.'】，不允许删除');
        }
        $bool = $permission->delete();
        if ($bool) {
            return dataFormat(0, '权限删除成功');
        }
        return dataFormat(1, '权限删除失败');
    }

}
