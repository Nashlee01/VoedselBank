<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Klant;
use App\Models\User;
use Illuminate\Support\Carbon;
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
            'gezinsnaam' => 'required|string|max:255',
            'straat' => 'required|string|max:255',
            'huisnummer' => 'required|string|max:50',
            'toevoeging' => 'nullable|string|max:50',
            'postcode' => 'required|string|max:20',
            'plaats' => 'required|string|max:255',
            'telefoonnummer' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'aantal_volwassenen' => 'required|integer|min:0',
            'aantal_kinderen' => 'required|integer|min:0',
            'aantal_babys' => 'required|integer|min:0',
            'geboortedata_volwassenen' => 'nullable|array',
            'geboortedata_volwassenen.*' => 'required|date',
            'geboortedata_kinderen' => 'nullable|array',
            'geboortedata_kinderen.*' => 'required|date',
            'geboortedata_babys' => 'nullable|array',
            'geboortedata_babys.*' => 'required|date',
            'password' => 'required|min:6|confirmed',
        ], [
            'email.unique' => 'Dit e-mailadres is al geregistreerd',
            'email.email' => 'Ongeldig e-mailadres',
            'password.min' => 'Wachtwoord moet minimaal 6 tekens zijn',
            'password.confirmed' => 'Wachtwoorden komen niet overeen',
        ]);

        if ($validated['aantal_volwassenen'] > 0) {
            $adultDates = $validated['geboortedata_volwassenen'] ?? [];
            if (count($adultDates) !== $validated['aantal_volwassenen']) {
                return back()
                    ->withErrors(['geboortedata_volwassenen' => 'Voer een geboortedatum in voor elke volwassene'])
                    ->withInput();
            }
        }

        if ($validated['aantal_kinderen'] > 0) {
            $childDates = $validated['geboortedata_kinderen'] ?? [];
            if (count($childDates) !== $validated['aantal_kinderen']) {
                return back()
                    ->withErrors(['geboortedata_kinderen' => 'Voer een geboortedatum in voor elk kind'])
                    ->withInput();
            }
        }

        if ($validated['aantal_babys'] > 0) {
            $babyDates = $validated['geboortedata_babys'] ?? [];
            if (count($babyDates) !== $validated['aantal_babys']) {
                return back()
                    ->withErrors(['geboortedata_babys' => 'Voer een geboortedatum in voor elke baby'])
                    ->withInput();
            }
        }

        $user = User::create([
            'name' => $validated['gezinsnaam'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Klant::create([
            'gezinsnaam' => $validated['gezinsnaam'],
            'straat' => $validated['straat'],
            'huisnummer' => $validated['huisnummer'],
            'toevoeging' => $validated['toevoeging'] ?? null,
            'postcode' => $validated['postcode'],
            'plaats' => $validated['plaats'],
            'telefoonnummer' => $validated['telefoonnummer'],
            'email' => $validated['email'],
            'aantal_volwassenen' => $validated['aantal_volwassenen'],
            'aantal_kinderen' => $validated['aantal_kinderen'],
            'aantal_babys' => $validated['aantal_babys'],
            'geboortedata_volwassenen' => isset($validated['geboortedata_volwassenen'])
                ? json_encode($validated['geboortedata_volwassenen'])
                : null,
            'geboortedata_kinderen' => isset($validated['geboortedata_kinderen'])
                ? json_encode($validated['geboortedata_kinderen'])
                : null,
            'geboortedata_babys' => isset($validated['geboortedata_babys'])
                ? json_encode($validated['geboortedata_babys'])
                : null,
            'is_actief' => true,
            'datum_aangemaakt' => Carbon::now(),
            'datum_gewijzigd' => Carbon::now(),
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
