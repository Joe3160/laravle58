<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use SoftDeletes;
    /**
     * 不可以批量赋值的属性
     * @var array
     */
    protected $guarded = [];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }


}
