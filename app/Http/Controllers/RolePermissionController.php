<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    public function index(Role $role)
    {
        if ($role->name == 'Super Admin') {
            return redirect()->route('role.index')->with('error', 'Permissão do super admin não pode ser acessada!');
        }

        $rolePermissions = DB::table('role_has_permissions')
            ->where('role_id', $role->id)
            ->pluck('permission_id')
            ->all();

        $permissions = Permission::get();

        return view('rolePermission.index', [
            'menu' => 'roles',
            'rolePermissions' => $rolePermissions,
            'permissions' => $permissions,
            'role' => $role,
        ]);
    }

    public function update(Request $request, Role $role)
    {
        $permission = Permission::find($request->permission);

        if (!$permission) {
            return redirect()->route('role-permission.update', ['role' => $role->id, 'permission' => $request->permission ])->with('error', 'Permissão não encontrada!');
        }

        if ($role->permissions->contains($permission)) {
            $role->revokePermissionTo($permission);

            return redirect()->route('role-permission.index', ['role' => $role->id])->with('success', "Permissão bloqueada com sucesso!");
        } else {
            $role->givePermissionTo($permission);

            return redirect()->route('role-permission.index', ['role' => $role->id])->with('success', "Permissão liberada com sucesso!");

        }

    }
}
