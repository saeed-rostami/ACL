<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    protected $guarded = ['id'];
    protected $casts = ['action' => 'array'];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
