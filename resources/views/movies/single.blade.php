@extends('base')

@section('content')

    @php
        $posterUrl = isset($movie_data->image) ? Storage::url($movie_data->image) : null;
        $backdropUrl = isset($movie_data->backdrop_path)
            ? 'https://image.tmdb.org/t/p/original/' . ltrim($movie_data->backdrop_path, '/')
            : ($posterUrl ?? null);
        $title = $movie_data->name ?? $movie_data->title ?? 'Film';
        $releaseDate = $movie_data->release_date ?? null;
        $vote = $movie_data->vote_average ?? null;
        $genres = $movie_data->genres ?? [];
        $directors = $movie_data->directors ?? [];
        $director = collect($directors)->first();
        $casts = collect($movie_data->casts ?? [])->take(9);
        $overview = $movie_data->desc ?? $movie_data->overview ?? null;
    @endphp

    <section class="single-hero" style="--hero-bg: url('{{ $backdropUrl }}')">
        <div class="single-hero__overlay"></div>
        <div class="single-hero__content">
            <div class="single-hero__poster">
                @if($posterUrl)
                    <img src="{{ $posterUrl }}" alt="Poster {{ $title }}">
                @endif
            </div>
            <div class="single-hero__info">
                <h1 class="single-hero__title">{{ $title }}</h1>
                <div class="single-hero__meta">
                    @if($vote)
                        <span class="rating"><i class='bx bxs-star'></i> {{ number_format($vote, 1) }} / 10</span>
                    @endif
                    @if($releaseDate)
                        <span class="dot">•</span>
                        <span class="date">{{ $releaseDate }}</span>
                    @endif
                </div>
                @if(!empty($genres))
                    <div class="single-hero__tags">
                        @foreach ($genres as $genre)
                            <span class="tag">{{ is_object($genre) ? ($genre->name ?? $genre->title ?? $genre) : $genre }}</span>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>

    <section class="single-details">
        @if($overview)
            <div class="single-overview">
                <p>{{ $overview }}</p>
            </div>
        @endif
        @if($director)
            <div class="director-card">
                <div class="director-card__avatar">
                    @php
                        $rawDirImg = isset($director->image) ? $director->image : (isset($director['image']) ? $director['image'] : (isset($director->profile_path) ? $director->profile_path : (isset($director['profile_path']) ? $director['profile_path'] : null)));
                        $dirImg = $rawDirImg;
                        if($dirImg && !\Illuminate\Support\Str::startsWith($dirImg, 'http')) {
                            $dirImg = 'https://image.tmdb.org/t/p/w185' . (\Illuminate\Support\Str::startsWith($dirImg, '/') ? $dirImg : '/' . $dirImg);
                        }
                    @endphp
                    @if($dirImg)
                        <img src="{{ $dirImg }}" alt="{{ $director->name ?? $director['name'] ?? 'Réalisateur' }}">
                    @else
                        <div class="avatar-fallback">{{ \Illuminate\Support\Str::substr(($director->name ?? $director['name'] ?? 'R'),0,1) }}</div>
                    @endif
                </div>
                <div>
                    <p class="label">Réalisé par</p>
                    <p class="name">{{ $director->name ?? $director['name'] ?? 'Inconnu' }}</p>
                </div>
            </div>
        @endif

        @if($casts && $casts->count())
            <div class="cast-grid">
                @foreach ($casts as $cast)
                    @php
                        $castName = is_object($cast) ? ($cast->name ?? $cast->original_name ?? 'Acteur') : ($cast['name'] ?? 'Acteur');
                        $castRole = is_object($cast) ? ($cast->pseudo ?? ($cast->character ?? null)) : ($cast['pseudo'] ?? ($cast['character'] ?? null));
                        $castImg = is_object($cast)
                            ? ($cast->image ?? $cast->profile_path ?? null)
                            : ($cast['image'] ?? $cast['profile_path'] ?? null);
                        if($castImg && !\Illuminate\Support\Str::startsWith($castImg, 'http')) {
                            $castImg = 'https://image.tmdb.org/t/p/w185' . (\Illuminate\Support\Str::startsWith($castImg, '/') ? $castImg : '/' . $castImg);
                        }
                    @endphp
                    <div class="cast-card">
                        <div class="cast-card__avatar">
                            @if($castImg)
                                <img src="{{ $castImg }}" alt="{{ $castName }}">
                            @else
                                <div class="avatar-fallback">{{ \Illuminate\Support\Str::substr($castName,0,1) }}</div>
                            @endif
                        </div>
                        <p class="cast-card__name">{{ $castName }}</p>
                        @if($castRole)
                            <p class="cast-card__role">{{ $castRole }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    @php
        $isSeries = isset($movie_data->is_movie) ? !$movie_data->is_movie : false;
        $episodes = collect($movie_data->episodes ?? []);
        $episodesBySeason = $episodes->groupBy(function($ep){
            return is_object($ep) ? ($ep->season ?? 0) : ($ep['season'] ?? 0);
        })->sortKeys();
    @endphp
    @if($isSeries && $episodesBySeason->isNotEmpty())
        <section class="single-seasons">
            <div class="seasons-inner">
                <h2 class="seasons-title">Saisons & Épisodes</h2>
                <div class="seasons-accordion">
                    @foreach ($episodesBySeason as $seasonNumber => $seasonEpisodes)
                        @php $seasonLabel = 'Saison ' . (string)$seasonNumber; @endphp
                        <details class="season">
                            <summary>
                                <span class="season-badge">S{{ str_pad((string)($seasonNumber ?? 0), 2, '0', STR_PAD_LEFT) }}</span>
                                <span class="season-title">{{ $seasonLabel }}</span>
                                <span class="season-arrow" aria-hidden="true"></span>
                            </summary>
                            @if($seasonEpisodes && $seasonEpisodes->count())
                                <div class="episode-list">
                                    @foreach ($seasonEpisodes as $episode)
                                        @php
                                            $epName = is_object($episode) ? ($episode->name ?? 'Épisode') : ($episode['name'] ?? 'Épisode');
                                            $epOverview = is_object($episode) ? ($episode->overview ?? null) : ($episode['overview'] ?? null);
                                            $epRuntime = is_object($episode) ? ($episode->duration ?? null) : ($episode['duration'] ?? null);
                                            $epImg = is_object($episode) ? ($episode->image ?? null) : ($episode['image'] ?? null);
                                            if($epImg && !\Illuminate\Support\Str::startsWith($epImg, 'http')) {
                                                $epImg = 'https://image.tmdb.org/t/p/w300' . (\Illuminate\Support\Str::startsWith($epImg, '/') ? $epImg : '/' . $epImg);
                                            }
                                        @endphp
                                        <div class="episode-card">
                                            @if($epImg)
                                                <div class="episode-media">
                                                    <img src="{{ $epImg }}" alt="{{ $epName }}">
                                                </div>
                                            @endif
                                            <div class="episode-content">
                                                <h3 class="episode-title">{{ $epName }}</h3>
                                                @if($epRuntime)
                                                    <p class="episode-meta">Durée: {{ is_string($epRuntime) ? $epRuntime : ($epRuntime . ' min') }}</p>
                                                @endif
                                                @if($epOverview)
                                                    <p class="episode-overview">{{ $epOverview }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </details>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@endsection