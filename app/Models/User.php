<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;

    //用户拥有多个角色,多对多
    public function roles()
    {
        //return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($role)
    {
        $name = is_string($role) ? $role : $role->name;
        return !!$this->whereHas('roles', function ($query) use ($name) {
            $query->where('name', $name);
        })->get();
    }

}
