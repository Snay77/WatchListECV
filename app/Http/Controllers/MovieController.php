<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Actor;
use App\Models\Cast;
use App\Models\Director;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\Title;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\Empty_;

class MovieController extends Controller
{
    // public function getPopular()
    // {
    //     // dd('test');
    //     $movies_data = $this->getCurlData("/movie/popular?language=fr-FR&page=1");
    //     // dd($movies_data);
    //     return view('movies.list', ['movies_data' => $movies_data,]);
    // }

    // public function getTop()
    // {
    //     // dd('test');
    //     $movies_data = $this->getCurlData("/movie/top_rated?language=fr-FR&page=1");
    //     // dd($movies_data);
    //     return view('movies.top', ['movies_data' => $movies_data,]);
    // }

    // public function getSearch(Request $request)
    // {
    //     $query = $request->input('search');
    //     $movies_data = $this->getCurlData('/search/movie?query=' . $query . '&include_adult=false&language=fr-FR&page=1');
    //     return view('movies.list', [
    //         'movies_data' => $movies_data,
    //         'page_title' => 'Résultats de la recherche',
    //         'type' => 'search',
    //     ]);
    // }

    // public function getMovies(Request $request, $type)
    // {
    //     // $series_data = $this->getCurlData("/movie/8452?language=fr-FR&page=1");
    //     // dd($series_data);
    //     $genres_data = $this->getCurlData('/genre/movie/list?language=fr-FR');
    //     // dd($genres_data);


    //     $type_name = [
    //         'popular' => 'Film populaire',
    //         'top_rated' => 'Film les mieux notés',
    //     ];

    //     if ($type === 'popular') {

    //         $page = $request->query('page', 1);
    //         $movies_data = $this->getCurlData("/movie/popular?language=fr-FR&page={$page}");
    //         $series_data = $this->getCurlData("/tv/popular?language=fr-FR&page={$page}");
    //     } elseif ($type === 'top_rated') {
    //         $allMovies = [];
    //         $allSeries = [];
    //         $page = 1;

    //         while (count($allMovies) < 100 && $page <= 5) {
    //             $data = $this->getCurlData("/movie/top_rated?language=fr-FR&page={$page}");
    //             $allMovies = array_merge($allMovies, $data->results);
    //             $data = $this->getCurlData("/tv/top_rated?language=fr-FR&page={$page}");
    //             $allSeries = array_merge($allSeries, $data->results);
    //             $page++;
    //         }

    //         $movies_data = (object)[
    //             'results' => array_slice($allMovies, 0, 100),
    //             'page' => 1,
    //             'total_pages' => 1,
                
    //         ];

    //         $series_data = (object)[
    //             'results' => array_slice($allSeries, 0, 100),
    //             'page' => 1,
    //             'total_pages' => 1,

    //         ];
    //     }

    //     return view('movies.list', [
    //         'movies_data' => $movies_data,
    //         'series_data' => $series_data,
    //         'page_title'  => $type_name[$type],
    //         'type'        => $type,
    //         'genres_data' => $genres_data,
    //     ]);
    // }

    public function getMovie($type)
    {
        // dd($type);
        $movie = Title::with('genres')->with('casts')->with('directors')->find($type);
        // dd($type == $movie->id);
        if (!empty($movie)) {
            return view('titles.single', ['movie_data' => $movie]);
        } else {
            return Redirect::back()->with('movie_not_find', "Le Film n'est pas disponible");
        }
    }

    public function index()
    {
        $movies = Title::all();
        return view('movies.index', [
            'movies_data' => $movies,
        ]);
    }

    public function setMovieSeen(Request $request)
    { // il faut aller faire le form
        if ($request->has('id_movie')) {
            $movie = Title::find($request->input('id_movie'));
            if ($movie->seen == 1) {
                $movie->seen = 0;
            } else {
                $movie->seen = 1;
            }
            $movie->save();
        }
        return Redirect::back();
    }


    public function deleteMovie(Title $movie)
    {
        $movie->delete();
        return Redirect::back();
    }

    public function getCurlData($url)
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.themoviedb.org/3" . $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiIzYjZiOTA0ODUwOTAwMmI0OGFhNjE3OGFmOTg3OTdmOCIsIm5iZiI6MTUyNjg5MjY4Mi4xMTksInN1YiI6IjViMDI4ODhhMGUwYTI2MjNlMzAxM2NiNiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.U__GCj6NGxqJW_3jGpP29dEbdjeLh0eJ7a5CCmAJzlk",
                "accept: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if (!$err) {
            return json_decode($response);
        }
    }
}
