<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Entities\UserPermission;

class RoleUserPivot extends Model
{
    protected $table = 'user_role';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function userRole()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
