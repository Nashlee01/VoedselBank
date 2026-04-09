<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.email' => 'Ongeldig e-mailadres',
            'password.min' => 'Wachtwoord moet minimaal 6 tekens zijn',
        ]);

        if (Auth::attempt($validated)) {
            $request->session()->regenerate();
            return redirect('/')->with('success', 'Je bent succesvol ingelogd');
        }

        return back()->withErrors([
            'email' => 'Het e-mailadres of wachtwoord is onjuist',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'email.unique' => 'Dit e-mailadres is al geregistreerd',
            'email.email' => 'Ongeldig e-mailadres',
            'password.min' => 'Wachtwoord moet minimaal 6 tekens zijn',
            'password.confirmed' => 'Wachtwoorden komen niet overeen',
        ]);

        $user = User::create([
            'name' => $validated['email'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return redirect('/')->with('success', 'Account succesvol aangemaakt');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Je bent succesvol uitgelogd');
    }
}
