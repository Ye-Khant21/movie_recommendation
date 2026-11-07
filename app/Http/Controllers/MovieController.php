<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MovieController extends Controller
{
    public function index(Request $request): View
    {
        $genres = Genre::query()->orderBy('name')->pluck('name');

        return view('movies.index', [
            'movies' => Movie::with(['genres', 'people'])->latest()->filter($request->only(['search', 'genre', 'director']))->paginate(10)->withQueryString(),
            'genres' => $genres,
            'likedMovieIds' => $this->likedMovieIds(),
        ]);
    }

    public function show(Movie $movie): View
    {
        $movie->load(['genres', 'people', 'comments.user']);

        return view('movies.show', [
            'movie' => $movie,
            'likedMovieIds' => $this->likedMovieIds(),
        ]);
    }

    public function favorites(): View
    {
        $likedMovieIds = $this->likedMovieIds();

        return view('movies.favorites', [
            'movies' => Movie::with(['genres', 'people'])->whereIn('id', $likedMovieIds)->latest()->get(),
            'likedMovieIds' => $likedMovieIds,
        ]);
    }

    public function toggleLike(Request $request, Movie $movie): RedirectResponse
    {
        $likedMovieIds = $this->likedMovieIds();

        $likedMovieIds = in_array($movie->id, $likedMovieIds, true)
            ? array_values(array_diff($likedMovieIds, [$movie->id]))
            : [...$likedMovieIds, $movie->id];

        $request->session()->put('liked_movies', $likedMovieIds);

        return back();
    }

    /**
     * @return list<int>
     */
    private function likedMovieIds(): array
    {
        return array_map('intval', session('liked_movies', []));
    }
}
