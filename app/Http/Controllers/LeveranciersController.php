<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leverancier;

class LeveranciersController extends Controller
{
    public function index()
    {
        $leveranciers = Leverancier::paginate(10);

        return view('leveranciers.index', compact('leveranciers'));
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
            'telefoon' => 'nullable|string|max:20',
            'adres' => 'nullable|string|max:500',
            'status' => 'required|in:actief,inactief',
        ], [
            'email.unique' => 'Leverancier met dit e-mailadres bestaat al',
            'email.email' => 'Ongeldig e-mailadres',
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
            'telefoon' => 'nullable|string|max:20',
            'adres' => 'nullable|string|max:500',
            'status' => 'required|in:actief,inactief',
        ], [
            'email.unique' => 'Leverancier bestaat al',
            'email.email' => 'Ongeldig e-mailadres',
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
