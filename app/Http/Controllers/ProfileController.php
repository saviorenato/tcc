<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateProfileRequest;

class ProfileController extends Controller
{
    public function show()
    {
        $user = User::where('id', Auth::id())->first();

        return view('profile.show', ['user' => $user]);
    }

    public function edit()
    {
        $user = User::where('id', Auth::id())->first();

        return view('profile.edit', ['user' => $user]);
    }

    public function update(UpdateProfileRequest $request)
    {
        $request->validated();

        $user = User::where('id', Auth::id())->first();

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return redirect()->route('profile.edit', ['user' => $request->user])->with('success', 'Perfil editado com sucesso!');
    }

    public function destroy(User $user)
    {
        if ($user->id != Auth::id()) {
            return redirect()->route('profile.show', [
                'menu' => 'transaction',
            ])->with('error', 'O Usuário não é válido!');
        }

        $user->delete();

        return redirect()->route('login.destroy', [
        'user' => $user
        ])->with('success', 'Usuário excluída com sucesso!');
    }
}
