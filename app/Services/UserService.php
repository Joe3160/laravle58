<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/8/14
 * Time: 13:08
 */

namespace App\Services;


use App\Models\User;
use Illuminate\Support\Str;

class UserService
{
    //获取权限目录树
    public function getPermissionTree($user_id)
    {
        $result = $this->getPermissionList($user_id);
        if ($result['code'] !== '0') {
            return $result;
        }
        $permission = $result['data'];
        $tree = getTree($permission, 0, 'sub_menu');
        return dataFormat(0, 'ok', $tree);
    }

    //获取权限列表
    public function getPermissionList($user_id)
    {
        $user = User::find($user_id);
        if (empty($user)) {
            return dataFormat(1, '用户不存在');
        }
        $permission = collect();
        foreach ($user->roles as $role) {
            $permission = $permission->concat($role->permissions);
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

}