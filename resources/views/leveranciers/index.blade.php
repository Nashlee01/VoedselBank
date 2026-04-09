@extends('layouts.layout')

@section('content')
<div class="container">
    <h1 class="page-title">Leveranciersoverzicht</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

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
        <p>Geen leveranciers gevonden.</p>
        <a href="/leveranciers/create" class="btn btn-primary" style="display: inline-block; width: auto;">Nieuwe leverancier toevoegen</a>
    @endif
</div>
@endsection
