<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css')}}">
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <div>
        <div class="header-inner">
            <div class="header-left">
                <div class="logo-3d" aria-label="MovieList">
                    <span class="logo-front">MovieList</span>
                    <span class="neon-ring" aria-hidden="true"></span>
                    <span class="neon-ring second" aria-hidden="true"></span>
                </div>
            </div>
            <div class="header-right">
                <nav>
                    <a href="{{ Route('home')}}">Accueil</a>
                    <a href="{{ Route('movie.get', 'popular') }}">Films Populaires</a>
                    <a href="{{ Route('movie.get', 'top_rated') }}">Top Films</a>
                    <a href="{{ Route('movie.index', 'index') }}">Voir tout les Films</a>
                </nav>
                <form action="{{ Route('movie.search') }}" method="GET">
                    @csrf
                    <input type="text" name="search" placeholder="Rechercher un film">
                    <input type="submit" value="Rechercher">
                </form>
            </div>
        </div>
    </div>
    <div id="app">
        @yield('content')
    </div>
    <footer class="site-footer">
        <div class="footer-inner">
            <div class="logo-3d" aria-label="MovieList">
                <span class="logo-front">MovieList</span>
                <span class="neon-ring" aria-hidden="true"></span>
                <span class="neon-ring second" aria-hidden="true"></span>
            </div>
            <div class="footer-nav">
                <a href="{{ Route('home') }}">Accueil</a>
                <a href="{{ Route('movie.get', 'popular') }}">Populaires</a>
                <a href="{{ Route('movie.get', 'top_rated') }}">Top</a>
                <a href="{{ Route('movie.index', 'index') }}">Tous les films</a>
            </div>
            <p class="copyright">© {{ date('Y') }} MovieList — All rights reserved.</p>
        </div>
    </footer>
</body>

</html>