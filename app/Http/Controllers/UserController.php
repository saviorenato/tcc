<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name', 'ASC')->paginate(10);

        return view('users.index', ['menu' => 'users', 'users' => $users]);
    }

    public function show(User $user)
    {
        return view('users.show', ['menu' => 'users', 'user' => $user]);
    }

    public function create()
    {
        $roles = Role::pluck('name')->all();

        return view('users.create', ['menu' => 'users', 'roles' => $roles]);
    }

    public function store(UserRequest $request)
    {
        $request->validated();

        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);

            $user->assignRole($request->roles);

            DB::commit();

            return redirect()->route('user.show', ['user' => $user->id])->with('success', 'Usuário cadastrado com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();

            return back()->withInput()->with('error', 'Usuário não cadastrado!');
        }
    }

    public function edit(User $user)
    {
        $roles = Role::pluck('name')->all();
        $userRoles = $user->roles->pluck('name')->first();

        return view('users.edit', ['menu' => 'users', 'user' => $user, 'roles' => $roles, 'userRoles' => $userRoles]);
    }

    public function update(UserRequest $request, User $user)
    {
        $request->validated();

        DB::beginTransaction();

        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            $user->syncRoles($request->roles);
            DB::commit();

            return redirect()->route('user.show', ['user' => $request->user])->with('success', 'Usuário editado com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();

            return back()->withInput()->with('error', 'Usuário não editado!');
        }
    }

    public function editPassword(User $user)
    {
        return view('users.editPassword', ['menu' => 'users', 'user' => $user]);
    }

    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|min:6',
        ], [
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'A senha deve ter pelo menos :min caracteres.',
        ]);

        DB::beginTransaction();

        try {
            $user->update([
                'password' => $request->password,
            ]);

            DB::commit();

            return redirect()->route('user.show', ['user' => $request->user])->with('success', 'Senha do usuário editada com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();

            return back()->withInput()->with('error', 'Senha do usuário não editada!');
        }
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
            $user->syncRoles([]);

            return redirect()->route('user.index')->with('success', 'Usuário excluído com sucesso!');
        } catch (Exception $e) {
            return redirect()->route('dashboard.index')->with('error', 'Usuário não excluído!');
        }
    }
}
