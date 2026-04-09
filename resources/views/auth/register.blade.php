@extends('layouts.guest')

@section('content')
<div class="container-centered">
    <div class="container-centered-form">
        <h1>Account aanmaken</h1>

        @if ($errors->any())
            <div class="alert alert-error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="/register" method="POST">
            @csrf

            <div class="form-container">
                <label for="email" class="form-label">Email *</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required class="form-input" />
            </div>


            <div class="form-container">
                <label for="password" class="form-label">Wachtwoord *</label>
                <input type="password" name="password" id="password" required class="form-input" />
            </div>

            <div class="form-container form-last">
                <label for="password_confirmation" class="form-label">Wachtwoord bevestigen *</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required class="form-input" />
            </div>

            <button type="submit" class="btn btn-success">Account aanmaken</button>
        </form>

        <div class="center-text margin-top-1">
            <p>Heb je al een account? <a href="/login">Inloggen</a></p>
        </div>
    </div>
</div>
@endsection
