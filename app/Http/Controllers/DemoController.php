<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DemoController extends Controller
{
    //
    public function index(Request $request, $method = '')
    {
        // \Debugbar::disable();
        if (method_exists($this, $method) && $method != __METHOD__) {
            return $this->$method($request);
        }
        abort(404);
    }

    public function role()
    {
        $role = new Role;
        $role->name = 'admin';
        $role->label = 'admin';
        $role->save();
        dump($role);
    }

    public function permission()
    {
        $permission = new Permission;
        $permission->name = 'edit_form';
        $permission->label = '编辑表单';
        $result = $permission->save();
        dump($result);
    }

    public function role_permission(Request $request)
    {
        $id = $request->input('id', 1);
        $permission = Permission::find($id);
        $role = Role::find(1);
        $result = $role->givePermission($permission);
        dump($result);
    }

    public function user_role(Request $request)
    {
        $id = $request->input('user_id', 1);
        $roleId = $request->input('role_id', 1);
        $user = User::find($id);
        $role = Role::find($roleId);
        $result = $user->roles()->save($role);
        dump($result);
    }

    public function user(Request $request)
    {
        $user=$request->user();
        $user = User::find(1);

        dump($user);

    }

    public function test2()
    {
        $user = \App\Models\User::find(1);
        $role = \App\Models\Role::find(1);
        dump($user->has('users'));
    }

    public function test3()
    {
        $role = \App\Models\Role::find(1);
        dump($role->permissions);
    }

    public function test4()
    {
        $role=\App\Models\Role::find(1);
        dump($role->users);
        dump($role->has('users')->first());
        //$a=$role->users()->detach(1);
        $a=$role->permissions()->detach();
        dump($a);
    }

    public function test5()
    {
        $result=DB::transaction(function () {
            return dataFormat(0,'ok');
        });
        return $result;
    }

    public function test6()
    {
        try {
            throw new \Exception('888');
        } catch (\Exception $e) {
            Log::error($e);
            // error_log($e->getMessage());
        }
    }
}
