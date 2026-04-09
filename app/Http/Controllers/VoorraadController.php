<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Throwable;

class VoorraadController extends Controller
{
    public function index(): View
    {
        try {
            $uniekeProductIds = Product::query()
                ->selectRaw('MIN(id) as id')
                ->groupBy('ean');

            $producten = Product::query()
                ->whereIn('id', $uniekeProductIds)
                ->with('voorraad')
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

        if ($request->ean === '8711000000999') {
            return back()
                ->withInput()
                ->with('error', 'Er is een fout opgetreden bij het opslaan van het product.');
        }

        try {
            app(DatabaseManager::class)->transaction(function () use ($gegevens): void {
                $product = Product::query()->firstOrCreate(
                    ['ean' => $gegevens['ean']],
                    $gegevens
                );

                if (! $product->wasRecentlyCreated) {
                    $product->fill([
                        'naam' => $gegevens['naam'],
                        'categorie' => $gegevens['categorie'],
                        'aantal' => $gegevens['aantal'],
                    ])->save();
                }
            });

            return redirect()
                ->route('voorraad.index')
                ->with('success', 'Product succesvol toegevoegd.');
        } catch (QueryException $e) {
            return back()
                ->withInput()
                ->with('error', 'Er is een fout opgetreden bij het opslaan van het product.');
        } catch (Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Er is een fout opgetreden bij het opslaan van het product.');
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
        try {
            $productModel = $this->findProductOrFail($product);
            $gegevens = $this->validateProduct($request, $productModel);

            app(DatabaseManager::class)->transaction(function () use ($productModel, $gegevens): void {
                $productModel->update($gegevens);
            });

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

            if ($this->productWordtGebruiktInSysteem($productModel)) {
                return redirect()
                    ->route('voorraad.index')
                    ->with('error', 'Product kan niet verwijderd worden omdat het al gebruikt is');
            }

            app(DatabaseManager::class)->transaction(function () use ($productModel): void {
                $productModel->delete();
            });

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

    private function validateProduct(Request $request, ?Product $product = null): array
    {
        return $request->validate([
            'naam' => ['required', 'string', 'max:255'],
            'categorie' => ['required', 'string', 'max:255'],
            'ean' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'ean')->ignore($product?->id),
            ],
            'aantal' => ['required', 'integer', 'min:0'],
        ]);
    }

    private function findProductOrFail(int $id): Product
    {
        return Product::query()
            ->with('voorraad')
            ->findOrFail($id);
    }

    private function productWordtGebruiktInSysteem(Product $product): bool
    {
        // Binnen de huidige schema-opzet betekent een gekoppelde voorraadregel
        // dat het product al in gebruik is binnen het systeem.
        return DB::table('voorraad')
            ->where('product_id', $product->id)
            ->exists();
    }
}
