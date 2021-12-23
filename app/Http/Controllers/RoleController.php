<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\RoleUserPivot;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        return Role::all();
    }

    public function create(Request $request)
    {
        Role::query()->create([
            'title' => $request->title
        ]);

        return response()->json([
            'Role created'
        ]);
    }

    public function update(Request $request, $id)
    {
        $role = Role::query()->findOrFail($id);
        $role->update([
            'title' => $request->title
        ]);
        return response()->json([
            'Role Updated'
        ]);
    }

    public function destroy($id)
    {
        $role = Role::query()->findOrFail($id);
        if ($role) {
            $role->delete();
        }
        return response()->json([
            'Role Deleted'
        ]);
    }

    public function assignRole(Request $request)
    {
        $user = User::query()->findOrFail($request->user_id);
        $role = Role::query()->findOrFail($request->role_id);

        if ($user and $role) {
            RoleUserPivot::query()->create([
               'role_id' => $role->id,
               'user_id' => $user->id,
            ]);
        }

        return response()->json([
            'Role Assigned'
        ]);
    }
}
