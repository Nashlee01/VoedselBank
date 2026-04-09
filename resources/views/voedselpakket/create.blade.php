@extends('layouts.app')

@section('content')
<style>
    .page-wrapper {
        max-width: 800px;
        margin: 30px auto;
        background: #ffffff;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    }

    .page-title {
        font-size: 30px;
        font-weight: 700;
        margin-bottom: 20px;
        color: #111827;
    }

    .sub-text {
        margin-bottom: 25px;
        color: #374151;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #374151;
    }

    .form-control {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #d1d5db;
        border-radius: 10px;
        font-size: 15px;
        box-sizing: border-box;
    }

    .error-text {
        color: #dc2626;
        font-size: 14px;
        margin-top: 6px;
    }

    .btn-row {
        display: flex;
        gap: 12px;
        margin-top: 25px;
    }

    .btn {
        display: inline-block;
        padding: 12px 18px;
        border-radius: 10px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        font-size: 15px;
        font-weight: 600;
    }

    .btn-primary {
        background: #2563eb;
        color: white;
    }

    .btn-secondary {
        background: #6b7280;
        color: white;
    }
</style>

<div class="page-wrapper">
    <div class="page-title">Voedselpakket toevoegen</div>

    <div class="sub-text">
        U maakt een voedselpakket aan voor:
        <strong>{{ $klant->gezinsnaam }}</strong>
    </div>

    <form action="{{ route('voedselpakket.store') }}" method="POST">
        @csrf

        {{-- Verborgen koppeling naar de juiste klant --}}
        <input type="hidden" name="klant_id" value="{{ $klant->klant_id }}">

        <div class="form-group">
            <label for="datum_uitgifte" class="form-label">Datum uitgifte *</label>
            <input type="date"
                   name="datum_uitgifte"
                   id="datum_uitgifte"
                   class="form-control"
                   value="{{ old('datum_uitgifte') }}"
                   required>
            @error('datum_uitgifte')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="status" class="form-label">Status *</label>
            <select name="status" id="status" class="form-control" required>
                <option value="">-- Kies een status --</option>
                <option value="moet_nog_geleverd_worden" {{ old('status') === 'moet_nog_geleverd_worden' ? 'selected' : '' }}>
                    moet nog geleverd worden
                </option>
                <option value="uitgegeven" {{ old('status') === 'uitgegeven' ? 'selected' : '' }}>
                    uitgegeven
                </option>
                <option value="teruggebracht" {{ old('status') === 'teruggebracht' ? 'selected' : '' }}>
                    teruggebracht
                </option>
            </select>
            @error('status')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="btn-row">
            <button type="submit" class="btn btn-primary">Opslaan</button>
            <a href="{{ route('klanten.index') }}" class="btn btn-secondary">Terug</a>
        </div>
    </form>
</div>
@endsection