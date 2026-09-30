<?php

use App\Support\MovieCatalog;
use Illuminate\Support\Facades\Route;

Route::get('/', function (MovieCatalog $catalog) {
    return view('movies.index', [
        'movies' => $catalog->all(),
        'likedMovieIds' => $catalog->likedIds(),
    ]);
})->name('movies.index');

Route::get('/fan-favourites', function (MovieCatalog $catalog) {
    return view('movies.favorites', [
        'movies' => $catalog->favorites(),
        'likedMovieIds' => $catalog->likedIds(),
    ]);
})->name('movies.favorites');

Route::get('/movies/{id}', function (string $id, MovieCatalog $catalog) {
    $movie = $catalog->find((int) $id);

    abort_unless($movie, 404);

    return view('movies.show', [
        'movie' => $movie,
        'likedMovieIds' => $catalog->likedIds(),
    ]);
})->name('movies.show');

Route::post('/movies/{id}/like', function (string $id, MovieCatalog $catalog) {
    $catalog->toggleLike((int) $id);

    return back();
})->name('movies.like');

Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');
