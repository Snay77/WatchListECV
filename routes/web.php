<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\SerieController;
use App\Http\Controllers\StoreController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/popular', [MovieController::class, 'getPopular']);

// Route::post('/', [MovieController::class, 'popular_movies']);


Route::controller(MovieController::class)->prefix('/movies')->name('movie.')->group(function () { // on peut mettre ->prefix('/movie') avant le groupe | on peut aussi mettre ->name('blabla.')
    // Route::get('popular', 'getPopular')->name('popular'); // name('') et après {{ Route('') }}
    // Route::post('store', 'storeTitle')->name('store');
    Route::post('seen', 'setMovieSeen')->name('seen');

    Route::get('list/{type}', 'getMovies')->name('get');
    Route::get ('/movie/{type}', 'getMovie')->name('movie');
    
    Route::delete('/delete/{movie}', 'deleteMovie')->name('delete');
    
    Route::get('/index', 'index')->name('index');
});

Route::get('search', [HomeController::class, 'getSearch'])->name('search');
Route::post('store/{type}', [StoreController::class, 'storeTitle'])->name('store');


Route::controller(SerieController::class)->prefix('/series')->name('serie.')->group(function () { // on peut mettre ->prefix('/movie') avant le groupe | on peut aussi mettre ->name('blabla.')
    // Route::get('popular', 'getPopular')->name('popular'); // name('') et après {{ Route('') }}
    // Route::post('seen', 'setSerieSeen')->name('seen');

    // Route::get('search', 'getSearch')->name('search');
    Route::get('list/{type}', 'getSeries')->name('get');
    // Route::get ('/serie/{type}', 'getSerie')->name('serie');

    // Route::delete('/delete/{serie}', 'deleteSerie')->name('delete');

    // Route::get('/index', 'index')->name('index');
});

Route::get('/', [HomeController::class, 'getList'])->name('home');

// Route::controller(MovieController::class)->group(function() {
//     Route::get('/', 'getList')->name('home');
// });