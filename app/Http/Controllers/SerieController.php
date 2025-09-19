<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SerieController extends Controller
{

    public function getSeries(Request $request, $type)
    {
        $series_data = $this->getCurlData("/genre/tv/119051?language=fr-FR&page=1");
        dd($series_data);
        // $genres_data = $this->getCurlData('/genre/movie/list?language=fr-FR');

        $type_name = [
            'popular' => 'Série populaire',
            'top_rated' => 'Série les mieux notés',
        ];

        if ($type === 'popular') {

            $page = $request->query('page', 1);
            $series_data = $this->getCurlData("/tv/popular?language=fr-FR&page={$page}");
        } elseif ($type === 'top_rated') {
            $allSeries = [];
            $page = 1;

            while (count($allSeries) < 100 && $page <= 5) {
                $data = $this->getCurlData("/tv/top_rated?language=fr-FR&page={$page}");
                $allSeries = array_merge($allSeries, $data->results);
                $page++;
            }

            $series_data = (object)[
                'results' => array_slice($allSeries, 0, 100),
                'page' => 1,
                'total_pages' => 1,

            ];
        }

        return view('series.list', [
            'series_data' => $series_data,
            'page_title'  => $type_name[$type],
            'type'        => $type,
            // 'genres_data' => $genres_data,
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
