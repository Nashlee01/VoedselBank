@extends('layouts.app')

@section('title', 'Voorraad overzicht')

@section('content')
    <section class="page-section">
        <div class="container">
            <div class="page-header">
                <div>
                    <p class="page-eyebrow">Voorraadbeheer</p>
                    <h1>Voorraad overzicht</h1>
                    <p class="text-muted">Bekijk, wijzig en verwijder producten uit de voorraad.</p>
                </div>

                <a href="{{ route('voorraad.create') }}" class="btn btn-primary">Nieuw product toevoegen</a>
            </div>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if ($foutmelding)
                <div class="alert alert-danger">
                    {{ $foutmelding }}
                </div>
            @endif

            <div class="page-card">
                @if ($producten->isNotEmpty())
                    <div class="table-wrapper">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Naam</th>
                                    <th>Categorie</th>
                                    <th>EAN</th>
                                    <th>Aantal</th>
                                    <th>Status</th>
                                    <th>Acties</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($producten as $product)
                                    @php
                                        $isInGebruik = $product->voorraad !== null;
                                    @endphp
                                    <tr>
                                        <td>{{ $product->naam }}</td>
                                        <td>{{ $product->categorie }}</td>
                                        <td>{{ $product->ean }}</td>
                                        <td>{{ $product->aantal }}</td>
                                        <td>
                                            @if ($isInGebruik)
                                                <span class="status-badge status-badge-warning">In gebruik</span>
                                            @else
                                                <span class="status-badge status-badge-success">Niet in gebruik</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="actions">
                                                <a href="{{ route('voorraad.edit', $product->id) }}" class="btn btn-secondary btn-sm">
                                                    Wijzigen
                                                </a>

                                                @if ($isInGebruik)
                                                    <span class="status-note">Kan niet verwijderd worden</span>
                                                @else
                                                    <form action="{{ route('voorraad.destroy', $product->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            Verwijderen
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @elseif (! $foutmelding)
                    <div class="empty-state">
                        <h2>Er zijn nog geen producten</h2>
                        <p>Voeg het eerste product toe om de voorraad op te bouwen.</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
