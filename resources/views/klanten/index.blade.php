@extends('layouts.app')

@section('content')
<style>
    .page-wrapper {
        max-width: 1200px;
        margin: 30px auto;
        background: #fff;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    }

    .top-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        gap: 12px;
        flex-wrap: wrap;
    }

    .left-actions,
    .right-actions {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .page-title {
        font-size: 32px;
        font-weight: 700;
        color: #111827;
    }

    .btn {
        text-decoration: none;
        padding: 12px 18px;
        border-radius: 10px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        display: inline-block;
        font-size: 14px;
    }

    .btn-home {
        background: #6b7280;
        color: white;
    }

    .btn-primary {
        background: #2563eb;
        color: white;
    }

    .btn-warning {
        background: #f59e0b;
        color: white;
    }

    .btn-danger {
        background: #dc2626;
        color: white;
    }

    .btn-success {
        background: #16a34a;
        color: white;
    }

    .empty-message {
        padding: 16px;
        border-radius: 10px;
        background: #fef2f2;
        color: #991b1b;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th,
    .table td {
        padding: 14px;
        border-bottom: 1px solid #e5e7eb;
        text-align: left;
        vertical-align: middle;
    }

    .table th {
        background: #f9fafb;
    }

    .actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
</style>

<div class="page-wrapper">
    <div class="top-actions">
        <div class="left-actions">
            {{-- Simpele home link zonder named route problemen --}}
            <a href="/" class="btn btn-home">← Home</a>
            <div class="page-title">Klantoverzicht</div>
        </div>

        <div class="right-actions">
            <a href="{{ route('klanten.create') }}" class="btn btn-primary">Nieuwe klant toevoegen</a>
        </div>
    </div>

    @if($klanten->isEmpty())
        <div class="empty-message">
            Er zijn nog geen klanten geregistreerd.
        </div>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Gezinsnaam</th>
                    <th>Postcode</th>
                    <th>Plaats</th>
                    <th>Telefoonnummer</th>
                    <th>Email</th>
                    <th>Volwassenen</th>
                    <th>Kinderen</th>
                    <th>Baby's</th>
                    <th>Pakketten</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                @foreach($klanten as $klant)
                    <tr>
                        <td>{{ $klant->gezinsnaam }}</td>
                        <td>{{ $klant->postcode }}</td>
                        <td>{{ $klant->plaats }}</td>
                        <td>{{ $klant->telefoonnummer }}</td>
                        <td>{{ $klant->email }}</td>
                        <td>{{ $klant->aantal_volwassenen }}</td>
                        <td>{{ $klant->aantal_kinderen }}</td>
                        <td>{{ $klant->aantal_babys }}</td>
                        <td>{{ $klant->aantal_pakketten }}</td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('voedselpakket.create', $klant->klant_id) }}" class="btn btn-success">
                                    Pakket toevoegen
                                </a>

                                {{-- Belangrijk: route parameter expliciet meegeven --}}
                                <a href="{{ route('klanten.edit', ['klanten' => $klant->klant_id]) }}" class="btn btn-warning">
                                    Wijzigen
                                </a>

                                <form action="{{ route('klanten.destroy', ['klanten' => $klant->klant_id]) }}"
                                      method="POST"
                                      onsubmit="return confirm('Weet u zeker dat u deze klant wilt verwijderen?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger">
                                        Verwijderen
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection