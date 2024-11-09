<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use Exception;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('id')->paginate(40);

        return view('roles.index', ['menu' => 'roles', 'roles' => $roles]);
    }

    public function create()
    {
        return view('roles.create', [
            'menu' => 'roles',
        ]);
    }

    public function store(RoleRequest $request)
    {
        $request->validated();

        DB::beginTransaction();

        try {
            Role::create([
                'name' => $request->name,
            ]);

            DB::commit();

            return redirect()->route('role.index')->with('success', 'Papel cadastrado com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();

            return back()->withInput()->with('error', 'Papel não cadastrado!');
        }
    }

    public function edit(Role $role)
    {
        return view('roles.edit', [
            'menu' => 'roles',
            'role' => $role,
        ]);
    }

    public function update(RoleRequest $request, Role $role)
    {
        $request->validated();

        DB::beginTransaction();

        try {
            $role->update([
                'name' => $request->name,
            ]);

            DB::commit();

            return redirect()->route('role.index')->with('success', 'Papel editado com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();

            return back()->withInput()->with('error', 'Papel não editado!');
        }
    }

    public function destroy(Role $role)
    {
        if ($role->name == 'Super Admin') {
            return redirect()->route('role.index')->with('error', 'Papel super admin não pode ser excluído!');
        }

        if ($role->users->isNotEmpty()) {
            return redirect()->route('role.index')->with('error', 'Não é possível excluir o papel porque há usuários associados a ele.');
        }

        try {
            $role->delete();

            return redirect()->route('role.index')->with('success', 'Papel excluído com sucesso!');
        } catch (Exception $e) {
            return redirect()->route('role.index')->with('error', 'Papel não excluído!');
        }
    }
}
