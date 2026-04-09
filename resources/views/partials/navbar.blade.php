<nav class="site-nav">
    <div class="container site-nav-inner">
        <a href="{{ route('home') }}" class="site-brand">Voedselbank</a>

        <ul class="site-nav-links">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="/donate">Klanten</a></li>
            <li><a href="{{ route('voorraad.index') }}">Voorraad</a></li>
            <li><a href="/leveranciers">Leveranciers</a></li>

            @auth
                <li class="site-nav-text">Welkom, {{ auth()->user()->name }}</li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="site-nav-button">Uitloggen</button>
                    </form>
                </li>
            @else
                <li><a href="{{ route('login') }}">Inloggen</a></li>
                <li><a href="{{ route('register') }}">Registreren</a></li>
            @endauth
        </ul>
    </div>
</nav>
