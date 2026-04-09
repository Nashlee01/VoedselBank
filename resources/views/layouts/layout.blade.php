<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Voedselbank') }}</title>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
</head>
<body>
    @include('partials.navbar')

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <main>
    <main class="page-shell">
        @yield('content')
    </main>

    @include('partials.footer')
</body>
</html>
