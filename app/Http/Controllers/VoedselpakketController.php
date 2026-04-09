<?php

namespace App\Http\Controllers;

use App\Models\Klant;
use App\Models\Voedselpakket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VoedselpakketController extends Controller
{
    /**
     * Toon formulier om een nieuw voedselpakket toe te voegen
     * voor één specifieke klant.
     */
    public function create($klantId)
    {
        // Haal de klant op waarvoor het pakket gemaakt wordt
        $klant = Klant::findOrFail($klantId);

        return view('voedselpakket.create', compact('klant'));
    }

    /**
     * Sla nieuw voedselpakket op
     */
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Server-side validatie
        |--------------------------------------------------------------------------
        | We controleren of:
        | - de klant bestaat
        | - de datum geldig is
        | - de status één van de toegestane waarden heeft
        */
        $validated = $request->validate([
            'klant_id' => 'required|exists:klant,klant_id',
            'datum_uitgifte' => 'required|date',
            'status' => 'required|in:moet_nog_geleverd_worden,uitgegeven,teruggebracht',
        ], [
            'klant_id.required' => 'Er is geen klant geselecteerd.',
            'klant_id.exists' => 'De geselecteerde klant bestaat niet.',
            'datum_uitgifte.required' => 'De uitgiftedatum is verplicht.',
            'datum_uitgifte.date' => 'Voer een geldige datum in.',
            'status.required' => 'Status is verplicht.',
            'status.in' => 'De gekozen status is ongeldig.',
        ]);

        try {
            /*
            |--------------------------------------------------------------------------
            | Opslaan pakket
            |--------------------------------------------------------------------------
            | Hier koppelen we het voedselpakket aan de juiste klant via klant_id.
            */
            Voedselpakket::create([
                'klant_id' => $validated['klant_id'],
                'datum_uitgifte' => $validated['datum_uitgifte'],
                'status' => $validated['status'],
            ]);

            return redirect()
                ->route('klanten.index')
                ->with('success', 'Voedselpakket succesvol toegevoegd.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            
            /*
            |--------------------------------------------------------------------------
            | Logging
            |--------------------------------------------------------------------------
            | Technische fout loggen zodat je kunt zien wat er echt misgaat.
            */
            Log::error('Fout bij toevoegen voedselpakket: ' . $e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Het voedselpakket kon niet worden toegevoegd.');
        }
    }
}