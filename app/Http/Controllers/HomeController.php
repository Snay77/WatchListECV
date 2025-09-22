<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\Title;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function getList(Request $request) {
        // $list_data = Movie::all();
        $genres = Genre::withCount('titles')->get();

        $query = Title::where('seen', 0)->with('genres');

        if ($request->has('genre_id') && $request->genre_id != '') {
        $query->whereHas('genres', function($q) use ($request) {
            $q->where('genres.id', $request->genre_id);
        });
    }
    $movies = $query->get();
        
        // dd($list_data);
        return view('welcome', ['movies_data' => $movies,'genres' => $genres,'selected_genre' => $request->genre_id ?? '']);
    }

    public function getSearch(Request $request)
    {
        $query = $request->input('search');
        // $movies_data = $this->getCurlData('/search/movie?query=' . $query . '&include_adult=false&language=fr-FR&page=1');
        $movies_data = $this->getCurlData('/search/multi?query=' . $query . '&include_adult=false&language=fr-FR&page=1');
        return view('common.list', [
            'movies_data' => $movies_data,
            'page_title' => 'Résultats de la recherche',
            'type' => 'search',
        ]);
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
