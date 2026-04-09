<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Toon login pagina
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Verwerk login
     */
    public function login(Request $request)
    {
        // Server-side validatie voor inloggen
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.email' => 'Ongeldig e-mailadres',
            'password.min' => 'Wachtwoord moet minimaal 6 tekens zijn',
        ]);

        // Controleer of de combinatie van e-mail en wachtwoord klopt
        if (Auth::attempt($validated)) {
            // Security: genereer een nieuwe sessie na succesvol inloggen
            $request->session()->regenerate();

            return redirect('/')->with('success', 'Je bent succesvol ingelogd');
        }

        // Foutmelding als inloggen mislukt
        return back()->withErrors([
            'email' => 'Het e-mailadres of wachtwoord is onjuist',
        ])->onlyInput('email');
    }

    /**
     * Toon registratie pagina
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Verwerk registratie
     */
    public function register(Request $request)
    {
        // Server-side validatie voor registreren
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'email.unique' => 'Dit e-mailadres is al geregistreerd',
            'email.email' => 'Ongeldig e-mailadres',
            'password.min' => 'Wachtwoord moet minimaal 6 tekens zijn',
            'password.confirmed' => 'Wachtwoorden komen niet overeen',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Nieuwe gebruiker aanmaken
        |--------------------------------------------------------------------------
        | Hier slaan we alleen e-mail en wachtwoord op, omdat jouw users tabel
        | geen name kolom gebruikt.
        */
                $user = User::create([
            'username' => $validated['email'],
            'name' => $validated['email'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Log gebruiker direct in na registratie
        Auth::login($user);

        return redirect('/')->with('success', 'Account succesvol aangemaakt');
    }

    /**
     * Verwerk uitloggen
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Security: maak sessie ongeldig en genereer nieuwe token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Je bent succesvol uitgelogd');
    }
}