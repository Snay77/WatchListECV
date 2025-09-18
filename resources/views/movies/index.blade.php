@extends('base')

@section('content')

    @if ($movies_data)

        <section class="box-movies">

            <table>

                <head>
                    <tr>
                        <th>

                        </th>
                        <th>

                        </th>
                    </tr>
                </head>
                <tbody>
                    <tr>
                        @foreach ($movies_data as $movie)
                            <td>
                                <img src="https://image.tmdb.org/t/p/w500/.{{ $movie->poster_path }}" alt="">
                            </td>
                            <td>
                                {{ $movie->id }}
                            </td>
                            <td>
                                {{ $movie->name }}
                            </td>
                            <td>
                                <form action="{{ Route('movie.delete', $movie->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="submit" value="Supprimer">
                                </form>
                            </td>
                        @endforeach

                    </tr>
                </tbody>
            </table>

        </section>

    @endif

@endsection