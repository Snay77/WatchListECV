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
        <p>MovieList</p>
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
    <div id="app">
        @yield('content')
    </div>
</body>

</html>