    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', 'Roti Wonosari')</title>
        @stack('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <link rel="stylesheet" href="/css/@yield('css', 'home.css')">
    </head>
    <body>
        <nav class="navbar">
            <a href="{{ route('home') }}" class="navbar-brand">Roti Wonosari</a>
            <div class="navbar-menu">
                <a href="{{ route('home') }}">Beranda</a>
                <a href="{{ route('coba') }}">Menu Roti</a>
                <a href="#keunggulan">Tentang Kami</a>
                <a href="#kontak">Kontak</a>
                @auth
                        <form method="POST" action="{{ url('/logout') }}" class="d-inline ms-2">
                            @csrf
                            <button type="submit" class="btn btn-outline-roti">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ url('/login') }}" class="btn btn-roti-primary ms-2">Login</a>
                    @endauth
            </div>
        </nav>

        @yield('content')
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

        @stack('scripts')
    </body>
    </html>