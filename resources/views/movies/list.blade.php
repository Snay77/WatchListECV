@extends('base')

@section('content')

    @session('movie_added')
        <div>
            <p>{{ session('movie_added') }}</p>
        </div>
    @endsession

    <div>
        <h1>{{ $page_title }}</h1>

        @if ($type === 'popular')
            <p>Pages :{{ $movies_data->page }} / 20</p>
            @php
                $current = $movies_data->page;
                $maxPage = min($movies_data->total_pages, 20);
            @endphp

            <div class="pagination">
                @if ($current > 1)
                    <a class="movie-btn" href="{{ route('movie.get', ['type' => $type, 'page' => $current - 1]) }}">
                        Précédent
                    </a>
                @endif
                @if ($current < $maxPage)
                    <a class="movie-btn" href="{{ route('movie.get', ['type' => $type, 'page' => $current + 1]) }}">
                        Suivant
                    </a>
                @endif
            </div>
            @if ($movies_data->results)
                <section class="movies-box">
                    @foreach ($movies_data->results as $movie)
                        <div class="movie-card">
                            <div class="content-card">
                                <img src="https://image.tmdb.org/t/p/w500/.{{ $movie->poster_path }}" alt="">
                                <span class="shadow"></span>
                                <div class="content">
                                    <h3> {{ $movie->title }} </h3>
                                    <p class="date"> {{ $movie->release_date }}</p>
                                    <p> {{ $movie->vote_average }} / 10<i class='bxr  bxs-star' style='color:#ffffff'></i> </span></p>
                                    <div class="hex-tag">
                                        @foreach ($movie->genre_ids as $genre)
                                            <div class="tag">
                                                {{ $genre }}
                                            </div>
                                        @endforeach
                                    </div>
                                    <form action="{{ Route('movie.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="movie_id" value="{{ $movie->id }}">
                                        <button class="movie-btn" type="submit" name="save_movie">Ajouter à ma liste</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </section>
            @endif
        @else

            {{-- @if ($movies_data->results)
            <section class="box-movies">
                @foreach ($movies_data->results as $movie)
                <div class="box-poster">
                    <img src="https://image.tmdb.org/t/p/w500/.{{ $movie->poster_path }}" alt="">
                    <p> {{ $movie->title }}</p>

                    <p>{{ $movie->id }}</p>

                    <form action="{{ Route('movie.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="movie_id" value="{{ $movie->id }}">
                        <input type="submit" name="save_movie" value="Ajouter à ma liste">
                    </form>
                </div>

                @endforeach
            </section>
            @endif --}}

            @if ($movies_data->results)
                @php
                    $nbr = 1;
                @endphp
                <section class="movies-box">
                    @foreach ($movies_data->results as $movie)
                        <div class="movie-card">
                            <div class="content-card">
                                <img src="https://image.tmdb.org/t/p/w500/.{{ $movie->poster_path }}" alt="">
                                <span class="shadow"></span>
                                <div class="content">
                                    <h3> {{ $movie->title }} </h3>
                                    <p class="date"> {{ $movie->release_date }}</p>
                                    <p> {{ $movie->vote_average }} / 10<i class='bxr  bxs-star' style='color:#ffffff'></i> </span></p>
                                    <div class="hex-tag">
                                        @foreach ($movie->genre_ids as $genre)
                                            <div class="tag">
                                                {{ $genre }}
                                            </div>
                                        @endforeach
                                    </div>
                                    <form class="form-flex" action="{{ Route('movie.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="movie_id" value="{{ $movie->id }}">
                                        <button class="movie-btn" type="submit" name="save_movie">Ajouter à ma liste</button>
                                        <p>N°{{ $nbr }}</p>
                                    </form>
                                    @php
                                        $nbr = $nbr + 1;
                                    @endphp
                                </div>
                            </div>
                        </div>
                    @endforeach
                </section>
            @endif

        @endif
    </div>

@endsection