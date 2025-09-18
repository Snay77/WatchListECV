@extends('base')

@section('content')


    <h1>Liste des films</h1>
    @if ($movies_data)
        <section class="movies-box">
            @foreach ($movies_data as $movie)
                <div class="movie-card">
                    <div class="content-card">
                        <form class="form-index-delete" action="{{ Route('movie.delete', $movie->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            <button class="movie-btn movie-btn--danger delete-btn" type="submit" title="Supprimer">✕</button>
                        </form>
                        <a class="click-card" href="{{ Route('movie.movie', $movie->id) }}">
                            <img src="{{ Storage::url($movie->image) }}" alt="">
                            <span class="shadow"></span>
                            <div class="content">
                                <h2> {{ $movie->name }} </h2>
                                <p class="date"> {{ $movie->release_date }}</p>
                                <p> {{ $movie->vote_average }} / 10<i class='bxr  bxs-star' style='color:#ffffff'></i></p>
                                <div class="hex-tag">
                                    @foreach ($movie->genres as $genre)
                                        <div class="tag">{{ $genre->name }}</div>
                                    @endforeach
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </section>

    @endif

@endsection