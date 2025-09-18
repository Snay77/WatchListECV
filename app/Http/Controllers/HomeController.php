<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function getList(Request $request) {
        // $list_data = Movie::all();
        $genres = Genre::withCount('movies')->get();

        $query = Movie::where('seen', 0)->with('genres');

        if ($request->has('genre_id') && $request->genre_id != '') {
        $query->whereHas('genres', function($q) use ($request) {
            $q->where('id', $request->genre_id);
        });
    }
    $movies = $query->get();
        
        // dd($list_data);
        return view('welcome', ['movies_data' => $movies,'genres' => $genres,'selected_genre' => $request->genre_id ?? '']);
    }
}
