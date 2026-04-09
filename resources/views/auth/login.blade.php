@extends('layouts.guest')

@section('content')
<div class="container-centered auth-card">
    <div class="auth-card-inner">
        <h1>Welkom terug</h1>
        <p class="auth-intro">Log in om je klantaccount te beheren en je gegevens te bekijken.</p>

        @if ($errors->any())
            <div class="alert alert-error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="/login" method="POST">
            @csrf

            <div class="form-container">
                <label for="email" class="form-label">Email *</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required class="form-input" />
            </div>

            <div class="form-container form-last">
                <label for="password" class="form-label">Wachtwoord *</label>
                <input type="password" name="password" id="password" required class="form-input" />
            </div>

            <button type="submit" class="btn btn-primary">Inloggen</button>
        </form>

        <div class="center-text margin-top-1 auth-footer-text">
            <p>Nog geen account? <a href="/register">Registreren</a></p>
        </div>
    </div>
</div>
@endsection
