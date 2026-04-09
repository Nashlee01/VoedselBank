<?php

namespace App\Http\Controllers;

use App\Models\Klant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class KlantController extends Controller
{
    /**
     * Toon klantoverzicht
     */
    public function index()
    {
        try {
            /*
            |--------------------------------------------------------------------------
            | JOIN
            |--------------------------------------------------------------------------
            | LEFT JOIN zorgt ervoor dat ook klanten zonder voedselpakket zichtbaar
            | blijven. We tellen meteen hoeveel pakketten aan een klant gekoppeld zijn.
            */
            $klanten = DB::table('klant')
                ->leftJoin('voedselpakket', 'klant.klant_id', '=', 'voedselpakket.klant_id')
                ->select(
                    'klant.klant_id',
                    'klant.gezinsnaam',
                    'klant.postcode',
                    'klant.plaats',
                    'klant.telefoonnummer',
                    'klant.email',
                    'klant.aantal_volwassenen',
                    'klant.aantal_kinderen',
                    'klant.aantal_babys',
                    DB::raw('COUNT(voedselpakket.id) as aantal_pakketten')
                )
                ->groupBy(
                    'klant.klant_id',
                    'klant.gezinsnaam',
                    'klant.postcode',
                    'klant.plaats',
                    'klant.telefoonnummer',
                    'klant.email',
                    'klant.aantal_volwassenen',
                    'klant.aantal_kinderen',
                    'klant.aantal_babys'
                )
                ->orderBy('klant.gezinsnaam')
                ->get();

            return view('klanten.index', compact('klanten'));
        } catch (\Exception $e) {
            /*
            |--------------------------------------------------------------------------
            | Try catch + logging
            |--------------------------------------------------------------------------
            | Technische fouten loggen we voor ontwikkelaars.
            */
            Log::error('Fout bij laden klantoverzicht: ' . $e->getMessage());

            return redirect('/')
                ->with('error', 'Er is een fout opgetreden bij het laden van het klantoverzicht.');
        }
    }

    /**
     * Toon formulier nieuwe klant
     */
    public function create()
    {
        return view('klanten.create');
    }

    /**
     * Sla nieuwe klant op
     */
    public function store(Request $request)
    {
        $validated = $this->validateKlant($request);

        try {
            /*
            |--------------------------------------------------------------------------
            | Stored procedure
            |--------------------------------------------------------------------------
            | We slaan de klant op via een stored procedure en sturen de
            | geboortedata mee als JSON strings.
            */
            DB::statement('CALL sp_insert_klant(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $validated['gezinsnaam'],
                $validated['straat'],
                $validated['huisnummer'],
                $validated['toevoeging'] ?? null,
                $validated['postcode'],
                $validated['plaats'],
                $validated['telefoonnummer'],
                $validated['email'],
                $validated['aantal_volwassenen'],
                json_encode($validated['geboortedata_volwassenen']),
                $validated['aantal_kinderen'],
                json_encode($validated['geboortedata_kinderen']),
                $validated['aantal_babys'],
                json_encode($validated['geboortedata_babys']),
            ]);

            return redirect()
                ->route('klanten.index')
                ->with('success', 'Klant is succesvol opgeslagen.');
        } catch (\Exception $e) {
            Log::error('Fout bij toevoegen klant: ' . $e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'De klant kon niet worden toegevoegd.');
        }
    }

    /**
     * Toon formulier klant wijzigen
     */
    public function edit($klantId)
    {
        /*
        |--------------------------------------------------------------------------
        | Klant ophalen zonder impliciete route model binding
        |--------------------------------------------------------------------------
        | Dit voorkomt problemen met resource parameters zoals {klanten}.
        */
        $klant = Klant::findOrFail($klantId);

        return view('klanten.edit', compact('klant'));
    }

    /**
     * Werk bestaande klant bij
     */
    public function update(Request $request, $klantId)
    {
        $klant = Klant::findOrFail($klantId);

        $validated = $this->validateKlant($request);

        try {
            $klant->update($validated);

            return redirect()
                ->route('klanten.index')
                ->with('success', 'Klant is succesvol gewijzigd.');
        } catch (\Exception $e) {
            Log::error('Fout bij wijzigen klant: ' . $e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'De klant kon niet worden gewijzigd.');
        }
    }

    /**
     * Verwijder klant
     */
    public function destroy($klantId)
    {
        $klant = Klant::findOrFail($klantId);

        try {
            /*
            |--------------------------------------------------------------------------
            | Business rule
            |--------------------------------------------------------------------------
            | Een klant mag niet verwijderd worden als er al pakketten
            | aan gekoppeld zijn.
            */
            if ($klant->voedselpakketten()->exists()) {
                return redirect()
                    ->route('klanten.index')
                    ->with('error', 'Deze klant kan niet worden verwijderd omdat er al een voedselpakket aan deze klant gekoppeld is.');
            }

            $klant->delete();

            return redirect()
                ->route('klanten.index')
                ->with('success', 'Klant is succesvol verwijderd.');
        } catch (\Exception $e) {
            Log::error('Fout bij verwijderen klant: ' . $e->getMessage());

            return redirect()
                ->route('klanten.index')
                ->with('error', 'De klant kon niet worden verwijderd.');
        }
    }

    /**
     * Centrale validatie voor klant store en update
     */
    private function validateKlant(Request $request): array
    {
        $validator = Validator::make($request->all(), [
            'gezinsnaam' => 'required|string|max:255',
            'straat' => 'required|string|max:255',
            'huisnummer' => 'required|string|max:255',
            'toevoeging' => 'nullable|string|max:255',
            'postcode' => 'required|string|max:255',
            'plaats' => 'required|string|max:255',
            'telefoonnummer' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'aantal_volwassenen' => 'required|integer|min:0',
            'aantal_kinderen' => 'required|integer|min:0',
            'aantal_babys' => 'required|integer|min:0',

            'geboortedata_volwassenen' => 'nullable|array',
            'geboortedata_volwassenen.*' => 'nullable|date',
            'geboortedata_kinderen' => 'nullable|array',
            'geboortedata_kinderen.*' => 'nullable|date',
            'geboortedata_babys' => 'nullable|array',
            'geboortedata_babys.*' => 'nullable|date',
        ]);

        $validator->after(function ($validator) use ($request) {
            $volwassenen = (int) $request->aantal_volwassenen;
            $kinderen = (int) $request->aantal_kinderen;
            $babys = (int) $request->aantal_babys;

            $volwassenData = array_values(array_filter((array) $request->geboortedata_volwassenen));
            $kinderenData = array_values(array_filter((array) $request->geboortedata_kinderen));
            $babysData = array_values(array_filter((array) $request->geboortedata_babys));

            if (count($volwassenData) !== $volwassenen) {
                $validator->errors()->add('geboortedata_volwassenen', 'Voer een geboortedatum in voor elke volwassene.');
            }

            if (count($kinderenData) !== $kinderen) {
                $validator->errors()->add('geboortedata_kinderen', 'Voer een geboortedatum in voor elk kind.');
            }

            if (count($babysData) !== $babys) {
                $validator->errors()->add('geboortedata_babys', 'Voer een geboortedatum in voor elke baby.');
            }

            foreach ($volwassenData as $datum) {
                $leeftijd = Carbon::parse($datum)->age;
                if ($leeftijd < 18) {
                    $validator->errors()->add('geboortedata_volwassenen', 'Elke volwassene moet minimaal 18 jaar oud zijn.');
                    break;
                }
            }

            foreach ($kinderenData as $datum) {
                $leeftijd = Carbon::parse($datum)->age;
                if ($leeftijd < 2 || $leeftijd >= 18) {
                    $validator->errors()->add('geboortedata_kinderen', 'Kinderen moeten tussen de 2 en 17 jaar oud zijn.');
                    break;
                }
            }

            foreach ($babysData as $datum) {
                $leeftijd = Carbon::parse($datum)->age;
                if ($leeftijd > 2) {
                    $validator->errors()->add('geboortedata_babys', 'Baby’s moeten tussen de 0 en 2 jaar oud zijn.');
                    break;
                }
            }
        });

        $validated = $validator->validate();

        $validated['geboortedata_volwassenen'] = array_values(array_filter((array) ($validated['geboortedata_volwassenen'] ?? [])));
        $validated['geboortedata_kinderen'] = array_values(array_filter((array) ($validated['geboortedata_kinderen'] ?? [])));
        $validated['geboortedata_babys'] = array_values(array_filter((array) ($validated['geboortedata_babys'] ?? [])));

        return $validated;
    }
}