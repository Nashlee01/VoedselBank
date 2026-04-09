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

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="page-card">
                <form action="{{ route('voorraad.store') }}" method="POST" id="voorraad-create-form">
                    @csrf

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="naam">Naam</label>
                            <input type="text" id="naam" name="naam" value="{{ old('naam') }}" required>
                            @if ($errors->first('naam'))
                                <div class="alert alert-danger">{{ $errors->first('naam') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="categorie">Categorie</label>
                            <input type="text" id="categorie" name="categorie" value="{{ old('categorie') }}" required>
                            @if ($errors->first('categorie'))
                                <div class="alert alert-danger">{{ $errors->first('categorie') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="ean">EAN</label>
                            <input type="text" id="ean" name="ean" value="{{ old('ean') }}" required>
                            @if ($errors->first('ean'))
                                <div class="alert alert-danger">{{ $errors->first('ean') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="aantal">Aantal</label>
                            <input type="number" id="aantal" name="aantal" value="{{ old('aantal') }}" min="0" required>
                            @if ($errors->first('aantal'))
                                <div class="alert alert-danger">{{ $errors->first('aantal') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary" id="voorraad-submit-button">Opslaan</button>
                        <a href="{{ route('voorraad.index') }}" class="btn btn-secondary">Annuleren</a>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('voorraad-create-form');
            const submitButton = document.getElementById('voorraad-submit-button');

            if (!form || !submitButton) {
                return;
            }

            form.addEventListener('submit', function () {
                submitButton.disabled = true;
                submitButton.textContent = 'Opslaan...';
            });
        });
    </script>
@endsection
