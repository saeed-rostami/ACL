<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Auth\Authorizable;
use Modules\Core\Entities\PermissionUserPivot;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function role()
    {
        return $this->hasOne(RoleUserPivot::class);
    }


    public function currentRole()
    {
        return $this->hasOne(RoleUserPivot::class)->latest();
    }

    public function isAuthorized($model, $action, $userId)
    {
        return Db::table('role_permissions')
            ->where('model', $model)
            ->whereJsonContains('action', $action)
            ->join('user_role', 'user_role.role_id', '=', 'role_permissions.role_id')
            ->where('user_role.user_id', $userId)
            ->exists();
    }

}
