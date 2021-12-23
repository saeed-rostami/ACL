<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Entities\PermissionUserPivot;

class Role extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function users()
    {
        return $this->hasMany(RoleUserPivot::class, 'role_id')->with('user');
    }

    public function permissions()
    {
        return $this->hasMany(RolePermission::class, 'role_id', 'id');
    }


}
