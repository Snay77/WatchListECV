@extends('base')

@section('content')

    @session('movie_added')
        <div>
            <p>{{ session('movie_added') }}</p>
        </div>
    @endsession

    <div>
        <h1>{{ $page_title }}</h1>
        @if ($movies_data->results)
            @php
                $nbr = 1;
            @endphp
            <p>Les films correspondant</p>
            <section class="movies-box">
                @foreach ($movies_data->results as $movie)
                    @if ($movie->media_type === 'movie')
                        <div class="movie-card">
                            <div class="content-card">
                                <img src="https://image.tmdb.org/t/p/w500/.{{ $movie->poster_path }}" alt="">
                                <span class="shadow"></span>
                                <div class="content">
                                    <h2> {{ $movie->title }} </h2>
                                    <p class="date"> {{ $movie->release_date }}</p>
                                    <p><i class='bxr  bxs-star' style='color:#ffffff'></i> {{ $movie->vote_average*10 }}%</span></p>
                                    {{-- <div class="simu-tag"></div> --}}
                                    <div class="hex-tag">
                                        @foreach ($movie->genre_ids as $genre)
                                            <div class="tag">
                                                {{ $genre }}
                                            </div>
                                        @endforeach
                                    </div>
                                    <form class="form-flex" action="{{ Route('store', ['type' => 'movie'])  }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="title_id" value="{{ $movie->id }}">
                                        <button class="movie-btn" type="submit" name="save_title">Ajouter à ma liste</button>
                                        @if ($type === 'top_rated')
                                            <p>N°{{ $nbr }}</p>
                                        @endif
                                    </form>
                                    @php
                                        $nbr = $nbr + 1;
                                    @endphp
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </section>
            <p>Les séries correspondant</p>
            <section class="movies-box">
                @foreach ($movies_data->results as $movie)
                    @if ($movie->media_type === 'tv')
                        <?php            $serie = $movie; ?>
                        <div class="movie-card">
                            <div class="content-card">
                                <img src="https://image.tmdb.org/t/p/w500/.{{ $serie->poster_path }}" alt="">
                                <span class="shadow"></span>
                                <div class="content">
                                    <h2> {{ $serie->name }} </h2>
                                    <p class="date"> {{ $serie->first_air_date }}</p>
                                    <p><i class='bxr  bxs-star' style='color:#ffffff'></i> {{ $serie->vote_average*10 }}%</span></p>
                                    {{-- <div class="simu-tag"></div> --}}
                                    <div class="hex-tag">
                                        @foreach ($serie->genre_ids as $genre)
                                            <div class="tag">
                                                {{ $genre }}
                                            </div>
                                        @endforeach
                                    </div>
                                    <form action="{{ Route('store', ['type' => 'tv']) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="title_id" value="{{ $serie->id }}">
                                        <button class="movie-btn" type="submit" name="save_title">Ajouter à ma liste</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </section>
        @endif
    </div>

@endsection