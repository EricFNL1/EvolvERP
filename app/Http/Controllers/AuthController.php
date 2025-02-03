<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Certifique-se de que este namespace está correto


class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');
    $user = User::where('email', $credentials['email'])->first();

    if ($user) {
        // Verifica se a senha é válida
        if (Hash::check($credentials['password'], $user->password)) {
            // Atualiza a senha para usar Bcrypt se necessário
            if (Hash::needsRehash($user->password)) {
                $user->password = Hash::make($credentials['password']);
                $user->save();
            }

            Auth::login($user);
            return redirect()->route('dashboard');
        }

        // Senha em texto puro
        if ($credentials['password'] === $user->password) {
            $user->password = Hash::make($credentials['password']);
            $user->save();
            Auth::login($user);
            return redirect()->route('dashboard');
        }
    }

    return back()->withErrors(['email' => 'Credenciais inválidas']);
}

public function dashboard()
{
    if (Auth::check()) {
        $user = Auth::user();
        return view('dashboard', ['user' => $user]);
    } else {
        return redirect()->route('login');
    }
}

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
