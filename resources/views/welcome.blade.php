@extends('base')

@section('content')


    <h1>Salut installe toi</h1>

    @session('movie_not_find')
        <div>
            <p>{{ session('movie_not_find') }}</p>
        </div>
    @endsession

    <h2>Votre liste de film</h2>

    <form action="{{ route('home') }}" method="GET">
        <label for="genre_id">Filtrer par genre :</label>
        <select name="genre_id" id="genre_id" onchange="this.form.submit()">
            <option value="">Sélectionner votre genre</option>
            @foreach ($genres as $genre)
                <option value="{{ $genre->id }}" {{ $selected_genre == $genre->id ? 'selected' : '' }}>
                    {{ $genre->name }} ({{ $genre->movies_count }})
                </option>
            @endforeach
        </select>
    </form>

    <section class="movies-box">
        @foreach ($movies_data as $movie)
            <div class="movie-card">
                {{-- < ?php dd($movie)?> --}}
                    <div class="content-card">
                        <a class="click-card" href="{{ Route('movie.movie', $movie->id) }}">
                            <img src="{{ Storage::url($movie->image) }}" alt="">
                            <span class="shadow"></span>
                            <div class="content">
                                <h2> {{ $movie->name }} </h2>
                                {{-- <p> {{ $movie->genres->name }}</p> --}}
                                <p class="date"> {{ $movie->release_date }}</p>
                                <p> {{ $movie->vote_average }} / 10<i class='bxr  bxs-star' style='color:#ffffff'></i> </span>
                                </p>
                                <div class="hex-tag">
                                    @foreach ($movie->genres as $genre)
                                        <div class="tag">
                                            {{ $genre->name }}
                                        </div>
                                    @endforeach
                                </div>
                        </a>
                        {{-- <form action="{{ Route('movie.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="movie_id" value="{{ $movie->id }}">
                            <button class="movie-btn" type="submit" name="save_movie">Ajouter à ma liste</button>
                        </form> --}}
                        <form class="form-index" action="{{ Route('movie.seen') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_movie" value="{{ $movie->id }}">
                            <input class="movie-btn" type="submit" value="VU">
                        </form>
                    </div>
            </div>
            </div>
        @endforeach
    </section>


@endsection