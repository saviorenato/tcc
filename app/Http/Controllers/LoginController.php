<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\LoginUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index');
    }

    public function loginProcess(LoginRequest $request)
    {
        $request->validated();

        $authenticated = Auth::attempt(['email' => $request->email, 'password' => $request->password]);

        if (!$authenticated) {
            return back()->withInput()->with('error', 'E-mail ou senha inválido!');
        }

        $user = Auth::user();
        $user = User::find($user->id);

        $permissions = $user->getPermissionsViaRoles()->pluck('name')->toArray();

        if ($user->hasRole('Super Admin')) {
            $permissions = Permission::pluck('name')->toArray();
        }

        $user->syncPermissions($permissions);

        return redirect()->route('dashboard.index');
    }

    public function create()
    {
        return view('login.create');
    }

    public function store(LoginUserRequest $request)
    {
        $request->validated();

        DB::beginTransaction();

        try {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);

            $user->assignRole("Aluno");

            DB::commit();

            return redirect()->route('login.index')->with('success', 'Usuário cadastrado com sucesso!');

        } catch (Exception $e) {

            DB::rollBack();

            return back()->withInput()->with('error', 'Usuário não cadastrado!');
        }
    }

    public function destroy()
    {
        Auth::logout();

        return redirect()->route('login.index')->with('success', 'Deslogado com sucesso!');
    }

}
