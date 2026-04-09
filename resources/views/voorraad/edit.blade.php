@extends('layouts.app')

@section('title', 'Product wijzigen')

@section('content')
    <section class="page-section">
        <div class="container">
            <div class="page-header">
                <div>
                    <p class="page-eyebrow">Voorraadbeheer</p>
                    <h1>Product wijzigen</h1>
                    <p class="text-muted">Werk de productgegevens bij en sla de wijzigingen op.</p>
                </div>

                <a href="{{ route('voorraad.index') }}" class="btn btn-secondary">Terug naar overzicht</a>
            </div>

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="page-card">
                <form action="{{ route('voorraad.update', $product->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="naam">Naam</label>
                            <input type="text" id="naam" name="naam" value="{{ old('naam', $product->naam) }}" required>
                            @if ($errors->first('naam'))
                                <div class="alert alert-danger">{{ $errors->first('naam') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="categorie">Categorie</label>
                            <input type="text" id="categorie" name="categorie" value="{{ old('categorie', $product->categorie) }}" required>
                            @if ($errors->first('categorie'))
                                <div class="alert alert-danger">{{ $errors->first('categorie') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="ean">EAN</label>
                            <input type="text" id="ean" name="ean" value="{{ old('ean', $product->ean) }}" required>
                            @if ($errors->first('ean'))
                                <div class="alert alert-danger">{{ $errors->first('ean') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="aantal">Aantal</label>
                            <input type="number" id="aantal" name="aantal" value="{{ old('aantal', $product->aantal) }}" min="0" required>
                            @if ($errors->first('aantal'))
                                <div class="alert alert-danger">{{ $errors->first('aantal') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Opslaan</button>
                        <a href="{{ route('voorraad.index') }}" class="btn btn-secondary">Annuleren</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
