<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Actor;
use App\Models\Director;
use App\Models\Episode;
use App\Models\Genre;
use App\Models\Title;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{
    public function storeTitle(Request $request, $type)
    {
        // dd($request);
        if ($request->has('title_id') && $request->input('title_id') > 0) {
            $title_data = $this->getCurlData('/' . $type . '/' . $request->input('title_id') . '?language=fr-FR');
            // dd($title_data);
            $actors_data = $this->getCurlData('/' . $type . '/' . $request->input('title_id') . '/credits?language=fr-FR');
            if (isset($title_data->poster_path)) {
                $path = 'poster/' . $title_data->id . '.jpg';
                $response = Http::get('https://image.tmdb.org/t/p/w500/' . $title_data->poster_path);
                Storage::disk('public')->put($path, $response->body());
            }

            $title = new Title;
            $title->id_movie_tmdb = $title_data->id;
            $title->vote_average = $title_data->vote_average;
            $title->image = $path;
            $title->desc = $title_data->overview;
            if ($type === 'movie') {
                $title->is_movie = 1;
                $title->name = $title_data->title;
                $title->release_date = $title_data->release_date;
            }
            if ($type === 'tv') {
                $title->is_movie = 0;
                $title->name = $title_data->name;
                $title->release_date = $title_data->first_air_date;
            }
            $title->save();

            if (isset($title_data->genres)) {
                foreach ($title_data->genres as $tmdb_genre) {

                    $genre = Genre::firstOrCreate([
                        'id_genre_tmdb' => $tmdb_genre->id,
                        'name' => $tmdb_genre->name,
                    ]);
                    $title->genres()->attach($genre->id);
                }
            }

            if (!empty($actors_data->cast)) {
                // dd('salut');
                foreach ($actors_data->cast as $tmdb_cast) {
                    // dd($tmdb_cast);

                    $cast = Actor::firstOrCreate([
                        'id_actor_tmdb' => $tmdb_cast->id,
                        'name' => $tmdb_cast->name,
                        'image' => $tmdb_cast->profile_path,
                        'pseudo' => $tmdb_cast->character,
                    ]);
                    $title->casts()->attach($cast->id);
                }
            }

            // dd($actors_data->crew);

            if (!empty($actors_data->crew)) {
                // dd('salut');
                foreach ($actors_data->crew as $tmdb_director) {

                    if ($tmdb_director->known_for_department === 'Directing') {
                        $director = Director::firstOrCreate([
                            'id_director_tmdb' => $tmdb_director->id,
                            'name' => $tmdb_director->name,
                            'image' => $tmdb_director->profile_path,
                        ]);
                        $title->directors()->attach($director->id);

                        break;
                    }
                }
            }

            if ($type === 'tv') {
                $nbr_seasons = $title_data->seasons;
                // dd($nbr_seasons);
                foreach ($nbr_seasons as $season) {
                    $season_data = $this->getCurlData('/' . $type . '/' . $request->input('title_id') . '/season/' . $season->season_number . '?language=fr-FR');
                    $episodes_data = $season_data->episodes;
                    foreach ($episodes_data as $episode)
                        // dd($episode);
                        $episode = Episode::firstOrCreate([
                            'title_id' => $title->id,
                            'name' => $episode->name,
                            'overview' => $episode->overview,
                            'image' => $episode->still_path,
                            'episode_number' => $episode->episode_number,
                            'season' => $episode->season_number,
                            'duration' => gmdate('H:i:s', $episode->runtime * 60)
                        ]);
                    // $title->episodes()->attach($episode->id);

                }
                // dd($this->getCurlData('/' . $type . '/' . $request->input('title_id') . '/season/1?language=fr-FR'));
                $season_data = $this->getCurlData('/' . $type . '/' . $request->input('title_id') . '/season/1?language=fr-FR');
                // dd($season_data);
                // if(!empty())
            }

            // dd($this->getCurlData('/movie/1311031/credits?language=fr-FR'));


            if ($title->save()) {
                return Redirect::back()->with('movie_added', 'Le Film est ajouté');
                // ou return Redirect::back()->with('movie_added', 'Le Film est ajouté');
            } else {
                return Redirect::back()->with('movie_added', 'Le Film est pas ajouté');
            }
        }
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
