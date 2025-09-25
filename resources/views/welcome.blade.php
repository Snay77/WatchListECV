@extends('base')

@section('content')


    <h1>Salut installe toi devant ta watchlist</h1>

    @session('movie_not_find')
        <div>
            <p>{{ session('movie_not_find') }}</p>
        </div>
    @endsession
    <form action="{{ route('home') }}" method="GET">
        <label for="genre_id">Filtrer par genre :</label>
        <select name="genre_id" id="genre_id" onchange="this.form.submit()">
            <option value="">Sélectionner votre genre</option>
            @foreach ($genres as $genre)
                <option value="{{ $genre->id }}" {{ $selected_genre == $genre->id ? 'selected' : '' }}>
                    {{ $genre->name }} ({{ $genre->titles_count }})
                </option>
            @endforeach
        </select>
    </form>

    <p>Votre liste de film</p>
    <section class="movies-box">
        @foreach ($titles_data as $movie)
            @if ($movie->is_movie == 1)
                @if ($movie->seen == 0)
                    <div class="movie-card">
                        <div class="content-card">
                            <a class="click-card" href="{{ Route('movie.movie', $movie->id) }}">
                                <img src="{{ Storage::url($movie->image) }}" alt="">
                                <span class="shadow"></span>
                                <div class="content">
                                    <h2> {{ $movie->name }} </h2>
                                    <p class="date"> {{ $movie->release_date }}</p>
                                    <p><i class='bxr  bxs-star' style='color:#ffffff'></i> {{ $movie->vote_average }}%</span>
                                    </p>
                                    <div class="hex-tag">
                                        @foreach ($movie->genres as $genre)
                                            <div class="tag">
                                                {{ $genre->name }}
                                            </div>
                                        @endforeach
                                    </div>
                            </a>
                            <form class="form-index" action="{{ Route('movie.seen') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_movie" value="{{ $movie->id }}">
                                <input class="movie-btn" type="submit" value="VU">
                            </form>
                        </div>
                    </div>
                    </div>
                @elseif ($movie->seen == 1)
                    <div class="movie-card">
                        <div class="content-card">
                            <a class="click-card" href="{{ Route('movie.movie', $movie->id) }}">
                                <img class="title-vu" src="{{ Storage::url($movie->image) }}" alt="">
                                <span class="shadow-vu"></span>
                                <div class="content">
                            </a>
                        </div>
                    </div>
                    </div>
                @endif
            @endif
        @endforeach
    </section>

    <p>Votre liste de série</p>
    <section class="movies-box">
        @foreach ($titles_data as $serie)
            @if ($serie->is_movie == 0)
                <div class="movie-card">
                    <div class="content-card">
                        <a class="click-card" href="{{ Route('movie.movie', $serie->id) }}">
                            <img src="{{ Storage::url($serie->image) }}" alt="">
                            <span class="shadow"></span>
                            <div class="content">
                                <h2> {{ $serie->name }} </h2>
                                <p class="date"> {{ $serie->release_date }}</p>
                                <p><i class='bxr  bxs-star' style='color:#ffffff'></i> {{ $serie->vote_average }}%</span>
                                </p>
                                <div class="hex-tag">
                                    @foreach ($serie->genres as $genre)
                                        <div class="tag">
                                            {{ $genre->name }}
                                        </div>
                                    @endforeach
                                </div>
                        </a>
                        <p>Épisodes restant à voir :</p>
                        <form class="form-index" action="{{ Route('serie.seen') }}" method="POST">
                            @csrf
                            <select name="id_episode" id="">
                                @foreach ($serie->episodes as $episode)
                                    @if ($episode->seen == 0)
                                        <option value="{{ $episode->id }}">S{{$episode->season}}-{{$episode->episode_number}}</option>
                                    @endif
                                @endforeach
                            </select>
                            <input class="movie-btn" type="submit" value="VU">
                        </form>
                    </div>
                </div>
                </div>
            @endif
        @endforeach
    </section>

@endsection