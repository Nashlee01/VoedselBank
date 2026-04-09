@extends('layouts.app')

@section('title', 'Nieuw product toevoegen')

@section('content')
    <section class="page-section">
        <div class="container">
            <div class="page-header">
                <div>
                    <p class="page-eyebrow">Voorraadbeheer</p>
                    <h1>Nieuw product toevoegen</h1>
                    <p class="text-muted">Vul de gegevens van het product in en sla het op in de voorraad.</p>
                </div>

                <a href="{{ route('voorraad.index') }}" class="btn btn-secondary">Terug naar overzicht</a>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="page-card">
                <form action="{{ route('voorraad.store') }}" method="POST">
                    @csrf

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="naam">Naam</label>
                            <input type="text" id="naam" name="naam" value="{{ old('naam') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="categorie">Categorie</label>
                            <input type="text" id="categorie" name="categorie" value="{{ old('categorie') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="ean">EAN</label>
                            <input type="text" id="ean" name="ean" value="{{ old('ean') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="aantal">Aantal</label>
                            <input type="number" id="aantal" name="aantal" value="{{ old('aantal') }}" min="0" required>
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
