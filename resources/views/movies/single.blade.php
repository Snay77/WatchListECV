@extends('base')

@section('content')

    <div>

        <h1>{{ $movie_data->name }}</h1><br>
        <p>{{ $movie_data->genres }}</p><br>
        <p>{{ $movie_data->casts }}</p><br>
        <p>{{ $movie_data->directors }}</p><br>
        {{-- @foreach ($foreach as )
        
        @endforeach --}}

    </div>

@endsection