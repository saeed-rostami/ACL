<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        return RolePermission::all();
    }

    public function create(Request $request)
    {
        try {
            $role = Role::query()->findOrFail($request->role_id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'Role not found'
            ]);
        }
        if (!$role) {
            return response()->json([
                'Role Not Fount'
            ]);
        }
        RolePermission::query()->create([
            'role_id' => $role->id,
            'model' => $request->model,
            'action' => $request->action
        ]);

        return response()->json([
            'Permission Created'
        ]);
    }

    public function destroy($id)
    {
        $role = RolePermission::query()->find($id);
        $role->delete();

    }
}
