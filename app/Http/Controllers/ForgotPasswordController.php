<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function showForgotPassword()
    {
        return view('login.forgotPassword');
    }

    public function submitForgotPassword(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email',
            ],
            [
                'email.required' => 'O campo e-mail é obrigatório.',
                'email.email' => 'Necessário enviar e-mail válido.',
            ]
        );

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withInput()->with('error', 'E-mail não encontrado!');
        }

        try {
            Password::sendResetLink(
                $request->only('email')
            );

            return redirect()->route('login.index')->with('success', 'Enviado e-mail com instruções para recuperar a senha. Acesse a sua caixa de e-mail para recuperar a senha!');
        } catch (Exception $e){
            return back()->withInput()->with('error', 'Tente mais tarde!');

        }
    }

    public function showResetPassword(Request $request)
    {
        return view('login.resetPassword', ['token' => $request->token]);
    }

    public function submitResetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|min:6|confirmed',
        ]);

        try {

            $status = Password::reset(
                // only - Recuperar apenas os campos específicos do pedido: 'email', 'password', 'password_confirmation' e 'token'.
                $request->only('email', 'password', 'password_confirmation', 'token'),

                // Retornar o callback se a redefinição de senha for bem-sucedida
                function (User $user, string $password){

                    // forceFill - Forçar o acesso a atributos protegidos
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ]);

                    $user->save();
                }

            );

            return $status === Password::PASSWORD_RESET ? redirect()->route('login.index')->with('success', 'Senha atualizada com sucesso!') : redirect()->route('login.index')->with('error', __($status));
        }catch (Exception $e){
            return back()->withInput()->with('error', 'Tente mais tarde!');
        }
    }
}
