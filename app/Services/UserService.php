<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/8/14
 * Time: 13:08
 */

namespace App\Services;


use App\Models\User;

class UserService
{
    //获取权限
    public function getPermission(User $user)
    {
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
                'uri'        => $item->uri,
            ];
        });
        $tree = getTree($permission->toArray(), 0, 'sub_menu');
        return dataFormat(0, 'ok', $tree);
    }

}