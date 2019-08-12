<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    // $role = Role::first(); $p = Permission::first();
    // $role->givePermission($p);
    public function givePermission(Permission $permission)
    {
        return $this->permissions()->save($permission);
    }
}
