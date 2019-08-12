<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    //
    public function permissions()
    {
        // return $this->belongsToMany(Permission::class, 'permission_role', 'role_id', 'permission_id');
        return $this->belongsToMany(Permission::class);
    }

    public function givePermission(Permission $permission)
    {
        return $this->permissions()->save($permission);
    }
}
