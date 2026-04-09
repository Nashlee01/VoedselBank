<nav>
    <div>
        <a href="/" class="brand">Voedselbank</a>
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="/klanten">Klanten</a></li>
            <li><a href="/contact">Voorraad</a></li>
            <li><a href="/leveranciers">Leveranciers</a></li>

            @if (Auth::check())
                <li class="nav-divider">
                    <span class="welcome-text">Welkom, {{ Auth::user()->name }}</span>
                </li>
                <li>
                    <form action="/logout" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="logout-btn">Uitloggen</button>
                    </form>
                </li>
            @else
                <li class="nav-divider">
                    <a href="/login" class="login-link">Inloggen</a>
                </li>
                <li>
                    <a href="/register" class="register-link">Registreren</a>
                </li>
            @endif
        </ul>
    </div>
</nav>
