<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionRequest;
use Exception;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::orderBy('title')->paginate(40);

        return view('permissions.index', ['menu' => 'permissions', 'permissions' => $permissions]);
    }

    public function create()
    {
        return view('permissions.create', [
            'menu' => 'permissions',
        ]);
    }

    public function store(PermissionRequest $request)
    {
        $request->validated();

        DB::beginTransaction();

        try {
            Permission::create([
                'title' => $request->title,
                'name' => $request->name,
            ]);

            DB::commit();

            return redirect()->route('permission.index')->with('success', 'Página cadastrada com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();

            return back()->withInput()->with('error', 'Página não cadastrada!');
        }
    }

    public function edit(Permission $permission)
    {
        return view('permissions.edit', [
            'menu' => 'permissions',
            'permission' => $permission,
        ]);
    }

    public function update(PermissionRequest $request, Permission $permission)
    {

        $request->validated();

        DB::beginTransaction();

        try {
            $permission->update([
                'title' => $request->title,
                'name' => $request->name,
            ]);

            DB::commit();

            return redirect()->route('permission.index')->with('success', 'Página editada com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();

            return back()->withInput()->with('error', 'Página não editada!');
        }
    }

    public function destroy(Permission $permission)
    {
        try {
            $permission->delete();

            return redirect()->route('permission.index')->with('success', 'Página excluída com sucesso!');
        } catch (Exception $e) {
            return redirect()->route('permission.index')->with('error', 'Página não excluída!');
        }
    }
}
