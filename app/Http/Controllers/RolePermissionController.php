<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class RolePermissionController extends Controller
{
         public function createRole(Request $request)
        {
            $request->validate([
                'name' => 'required|string|unique:roles,name',
            ]);

            $role = Role::create(['name' => $request->name]);

            return response()->json([
                'message' => 'Role criado com sucesso!',
                'role' => $role
            ], 201);
        }


        public function assignPermissionsToRole(Request $request)
        {
             $request->validate([
                'role_name' => 'required|exists:roles,name',
                'permissions' => 'required|array',
                'permissions.*' => 'required|string|exists:permissions,name',
            ]);

             $role = Role::findByName($request->role_name);

             $permissions = Permission::whereIn('name', $request->permissions)->get();

             if ($permissions->count() != count($request->permissions)) {
                return response()->json([
                    'message' => 'Uma ou mais permissões não foram encontradas.',
                ], 400);
            }

             $role->syncPermissions($permissions);

             return response()->json([
                'message' => 'Permissões atribuídas com sucesso!',
                'role' => $role->name,
                'permissions' => $role->permissions->pluck('name'),
            ], 200);
        }


        public function getPermissions()
        {
            $permissions = Permission::all();

            return response()->json([
                'permissions' => $permissions->pluck('name'),
            ], 200);
        }

        public function getRolesWithPermissions()
        {
            $roles = Role::with('permissions')->get();

            return response()->json([
                'roles' => $roles->map(function ($role) {
                    return [
                        'name' => $role->name,
                        'guard_name' => $role->guard_name,
                        'permissions' => $role->permissions->pluck('name')
                    ];
                }),
            ], 200);
        }


        public function assignRoleToUser(Request $request)
        {
             $request->validate([
                'user_id' => 'required|exists:users,id',
                'role_name' => 'required|string|exists:roles,name',
            ]);

             $user = User::findOrFail($request->user_id);



             $role = Role::where('name', $request->role_name) ->first();

            if (!$role) {
                return response()->json(['error' => 'Role não encontrada ou guard incorreto.'], 404);
            }

             $user->assignRole($role);

             return response()->json([
                'message' => 'Role atribuída ao usuário com sucesso!',
                'user' => $user->name,
                'role' => $role->name,
                'user_roles' => $user->roles->pluck('name'),
            ], 200);
        }

        public function removePermissionFromRole(Request $request)
{
    $request->validate([
        'role_name' => 'required|string|exists:roles,name',
        'permission' => 'required|string|exists:permissions,name',
    ]);

    $role = Role::where('name', $request->role_name)
                ->where('guard_name', 'sanctum')
                ->firstOrFail();

    $permission = Permission::where('name', $request->permission)
                            ->where('guard_name', 'sanctum')
                            ->firstOrFail();

    $role->revokePermissionTo($permission);

    return response()->json([
        'message' => 'Permissão removida com sucesso!',
        'role' => $role->name,
        'removed_permission' => $permission->name,
    ], 200);
}

public function unassignRoleFromUser(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
    ]);

    $user = User::findOrFail($request->user_id);
    $user->roles()->detach();

    return response()->json([
        'message' => 'Papel desvinculado com sucesso!',
    ], 200);
}



}
