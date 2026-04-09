<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Throwable;

class VoorraadController extends Controller
{
    public function index(): View
    {
        try {
            $producten = Product::query()
                ->orderBy('naam')
                ->get();

            return view('voorraad.index', [
                'producten' => $producten,
                'foutmelding' => null,
            ]);
        } catch (Throwable $e) {
            return view('voorraad.index', [
                'producten' => collect(),
                'foutmelding' => 'Er is een fout opgetreden bij het laden van de voorraad',
            ]);
        }
    }

    public function create(): View
    {
        return view('voorraad.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $gegevens = $this->validateProduct($request);

        try {
            Product::create($gegevens);

            return redirect()
                ->route('voorraad.index')
                ->with('success', 'Product succesvol toegevoegd.');
        } catch (QueryException $e) {
            return back()
                ->withInput()
                ->with('error', 'Er is een fout opgetreden bij het opslaan van het product');
        }
    }

    public function edit(int $product): View|RedirectResponse
    {
        try {
            return view('voorraad.edit', [
                'product' => $this->findProductOrFail($product),
            ]);
        } catch (ModelNotFoundException $e) {
            return redirect()
                ->route('voorraad.index')
                ->with('error', 'Het geselecteerde product bestaat niet meer.');
        } catch (Throwable $e) {
            return redirect()
                ->route('voorraad.index')
                ->with('error', 'Er is een fout opgetreden bij het laden van het product');
        }
    }

    public function update(Request $request, int $product): RedirectResponse
    {
        $gegevens = $this->validateProduct($request);

        try {
            $productModel = $this->findProductOrFail($product);
            $productModel->update($gegevens);

            return redirect()
                ->route('voorraad.index')
                ->with('success', 'Product succesvol gewijzigd.');
        } catch (ModelNotFoundException $e) {
            return redirect()
                ->route('voorraad.index')
                ->with('error', 'Het geselecteerde product bestaat niet meer.');
        } catch (QueryException $e) {
            return back()
                ->withInput()
                ->with('error', 'Er is een fout opgetreden bij het wijzigen van de voorraad');
        }
    }

    public function destroy(int $product): RedirectResponse
    {
        try {
            $productModel = $this->findProductOrFail($product);

            if ($this->productWordtGebruiktInVoedselpakket($productModel)) {
                return redirect()
                    ->route('voorraad.index')
                    ->with('error', 'Product kan niet verwijderd worden omdat het al gebruikt is');
            }

            $productModel->delete();

            return redirect()
                ->route('voorraad.index')
                ->with('success', 'Product succesvol verwijderd.');
        } catch (ModelNotFoundException $e) {
            return redirect()
                ->route('voorraad.index')
                ->with('error', 'Het geselecteerde product bestaat niet meer.');
        } catch (QueryException $e) {
            return redirect()
                ->route('voorraad.index')
                ->with('error', 'Product kan niet verwijderd worden omdat het al gebruikt is');
        } catch (Throwable $e) {
            return redirect()
                ->route('voorraad.index')
                ->with('error', 'Er is een fout opgetreden bij het verwijderen van het product');
        }
    }

    private function validateProduct(Request $request): array
    {
        return $request->validate([
            'naam' => ['required', 'string', 'max:255'],
            'categorie' => ['required', 'string', 'max:255'],
            'ean' => ['required', 'string', 'max:255'],
            'aantal' => ['required', 'integer', 'min:0'],
        ]);
    }

    private function findProductOrFail(int $id): Product
    {
        return Product::query()->findOrFail($id);
    }

    private function productWordtGebruiktInVoedselpakket(Product $product): bool
    {
        // TODO: Koppel deze controle aan de echte voedselpakket-relatie zodra die tabellen/models beschikbaar zijn.
        if (! method_exists($product, 'voedselpakketten')) {
            return false;
        }

        try {
            return $product->voedselpakketten()->exists();
        } catch (Throwable $e) {
            return false;
        }
    }
}
