@extends('layouts.layout')

@section('content')
<div class="container" style="padding: 2rem;">
    <h1>Leveranciersoverzicht</h1>

    @if($leveranciers->count() > 0)
        <table style="width: 100%; border-collapse: collapse; margin-top: 2rem;">
            <thead>
                <tr style="background-color: #f8f9fa;">
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Naam</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Email</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Telefoon</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Adres</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leveranciers as $leverancier)
                    <tr>
                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $leverancier->naam }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $leverancier->email }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $leverancier->telefoon }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $leverancier->adres }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">{{ ucfirst($leverancier->status) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 2rem;">
            {{ $leveranciers->links() }}
        </div>
    @else
        <p>Geen leveranciers gevonden.</p>
        <a href="/leveranciers/create" style="display: inline-block; padding: 0.5rem 1rem; background-color: #007bff; color: white; text-decoration: none; border-radius: 4px;">Nieuwe leverancier toevoegen</a>
    @endif
</div>
@endsection
