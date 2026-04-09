@extends('layouts.layout')

@section('content')
<div class="container">
    <h1 class="page-title">Leveranciersoverzicht</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="margin-bottom-1">
        <form action="/leveranciers" method="GET" style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
            <input
                type="text"
                name="zoekterm"
                class="form-input"
                placeholder="Zoek op naam, email, telefoon, adres of status"
                value="{{ request('zoekterm') }}"
                style="max-width: 320px;"
            >
            <button type="submit" class="btn btn-primary">Zoeken</button>

            @if(request('zoekterm'))
                <a href="/leveranciers" class="btn btn-secondary">Reset</a>
            @endif
        </form>
    </div>

    @if($leveranciers->count() > 0)
        <div class="margin-bottom-1">
            <a href="/leveranciers/create" class="btn btn-primary" style="display: inline-block; width: auto;">+ Nieuwe leverancier toevoegen</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Naam</th>
                    <th>Email</th>
                    <th>Telefoon</th>
                    <th>Adres</th>
                    <th>Status</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leveranciers as $leverancier)
                    <tr>
                        <td>{{ $leverancier->naam }}</td>
                        <td>{{ $leverancier->email }}</td>
                        <td>{{ $leverancier->telefoon }}</td>
                        <td>{{ $leverancier->adres }}</td>
                        <td>{{ ucfirst($leverancier->status) }}</td>
                        <td class="table-actions">
                            <a href="/leveranciers/{{ $leverancier->id }}/edit">Wijzigen</a>
                            <form method="POST" action="/leveranciers/{{ $leverancier->id }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-link delete-btn" onclick="return confirm('Weet je zeker dat je deze leverancier wilt verwijderen?')">Verwijderen</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="margin-top-2">
            {{ $leveranciers->links() }}
        </div>
    @else
    @if(request('zoekterm'))
        <div class="alert alert-danger">
            Leverancier niet gevonden
        </div>
    @else
        <p>Geen leveranciers gevonden.</p>
    @endif

    <a href="/leveranciers/create" class="btn btn-primary" style="display: inline-block; width: auto;">
        Nieuwe leverancier toevoegen
    </a>
@endif
</div>
@endsection
