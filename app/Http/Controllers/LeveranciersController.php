<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leverancier;

class LeveranciersController extends Controller
{
    public function index(Request $request)
    {
        $zoekterm = $request->input('zoekterm');

        $leveranciers = Leverancier::query()
            ->when($zoekterm, function ($query, $zoekterm) {
                $query->where(function ($q) use ($zoekterm) {
                    $q->where('naam', 'like', '%' . $zoekterm . '%')
                      ->orWhere('email', 'like', '%' . $zoekterm . '%')
                      ->orWhere('telefoon', 'like', '%' . $zoekterm . '%')
                      ->orWhere('adres', 'like', '%' . $zoekterm . '%')
                      ->orWhere('status', 'like', '%' . $zoekterm . '%');
                });
            })
            ->paginate(10)
            ->appends(['zoekterm' => $zoekterm]);

        return view('leveranciers.index', compact('leveranciers', 'zoekterm'));
    }

    public function create()
    {
        return view('leveranciers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'naam' => 'required|string|max:255',
            'email' => 'required|email|unique:leverancier,email',
            'telefoon' => 'required|string|max:20',
            'adres' => 'required|string|max:500',
            'status' => 'required|in:actief,inactief',
        ], [
            'email.unique' => 'Leverancier met dit e-mailadres bestaat al',
            'email.email' => 'Ongeldig e-mailadres',
            'telefoon.required' => 'Telefoonnummer is verplicht',
            'adres.required' => 'Adres is verplicht',
        ]);

        Leverancier::create($validated);

        return redirect('/leveranciers')->with('success', 'Leverancier succesvol toegevoegd');
    }

    public function edit(Leverancier $leverancier)
    {
        return view('leveranciers.edit', compact('leverancier'));
    }

    public function update(Request $request, Leverancier $leverancier)
    {
        $validated = $request->validate([
            'naam' => 'required|string|max:255',
            'email' => 'required|email|unique:leverancier,email,' . $leverancier->id,
            'telefoon' => 'required|string|max:20',
            'adres' => 'required|string|max:500',
            'status' => 'required|in:actief,inactief',
        ], [
            'email.unique' => 'Leverancier bestaat al',
            'email.email' => 'Ongeldig e-mailadres',
            'telefoon.required' => 'Telefoonnummer is verplicht',
            'adres.required' => 'Adres is verplicht',
        ]);

        $leverancier->update($validated);

        return redirect('/leveranciers')->with('success', 'Wijzigingen succesvol opgeslagen');
    }

    public function destroy(Leverancier $leverancier)
    {
        $leverancier->delete();

        return redirect('/leveranciers')->with('success', 'Leverancier succesvol verwijderd');
    }
}
