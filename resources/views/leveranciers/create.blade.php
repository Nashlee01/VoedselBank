@extends('layouts.layout')

@section('content')
<div class="container">
    <h1 class="page-title">Nieuwe leverancier toevoegen</h1>

    @if ($errors->any())
        <div class="alert-errors">
            <strong>Fouten gevonden:</strong>
            <ul style="margin: 0; padding-left: 1.5rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/leveranciers" method="POST" style="max-width: 600px;">
        @csrf

        <div class="form-container">
            <label for="naam" class="form-label">Naam *</label>
            <input type="text" name="naam" id="naam" value="{{ old('naam') }}" required class="form-input" />
        </div>

        <div class="form-container">
            <label for="email" class="form-label">Email *</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required class="form-input" />
        </div>

        <div class="form-container">
            <label for="telefoon" class="form-label">Telefoon</label>
            <input type="text" name="telefoon" id="telefoon" value="{{ old('telefoon') }}" class="form-input" />
        </div>

        <div class="form-container">
            <label for="adres" class="form-label">Adres</label>
            <textarea name="adres" id="adres" class="form-textarea">{{ old('adres') }}</textarea>
        </div>

        <div class="form-container form-last">
            <label for="status" class="form-label">Status *</label>
            <select name="status" id="status" required class="form-select">
                <option value="actief" {{ old('status') == 'actief' ? 'selected' : '' }}>Actief</option>
                <option value="inactief" {{ old('status') == 'inactief' ? 'selected' : '' }}>Inactief</option>
            </select>
        </div>

        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="btn btn-success">Opslaan</button>
            <a href="/leveranciers" class="btn" style="background-color: #6c757d; color: white;">Annuleren</a>
        </div>
    </form>
</div>
@endsection
