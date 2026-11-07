<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\Person;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MovieController extends Controller
{
    public function index(Request $request): View
    {
        return view('admin.movies.index', [
            'movies' => Movie::with(['genres', 'people'])->latest()->filter($request->only(['search', 'genre', 'director']))->paginate(10)->withQueryString(),
        ]);
    }

    public function create(): View
    {
        return view('admin.movies.create', [
            'genres' => Genre::query()->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'genre_ids' => ['required', 'array', 'min:1'],
            'genre_ids.*' => ['integer', 'exists:genres,id'],
            'rating' => ['nullable', 'numeric', 'between:0,10'],
            'thumbnail' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'directors' => ['nullable', 'string', 'max:2000'],
            'cast_members' => ['nullable', 'string', 'max:5000'],
            'body' => ['nullable', 'string'],
        ]);

        $thumbnailPath = $request->file('thumbnail')->store('movies', 'public');
        $genres = Genre::query()->whereKey($validated['genre_ids'])->get();
        $directors = $this->creditNames($validated['directors'] ?? null);

        $movie = Movie::query()->create([
            'title' => $validated['title'],
            'director' => $directors[0] ?? null,
            'genre' => $genres->pluck('name')->join(', '),
            'rating' => $validated['rating'],
            'poster' => Storage::url($thumbnailPath),
            'body' => $validated['body'],
        ]);

        $movie->genres()->sync($genres->modelKeys());

        foreach (['director' => $directors, 'cast' => $this->creditNames($validated['cast_members'] ?? null)] as $role => $names) {
            foreach ($names as $name) {
                $person = Person::query()->firstOrCreate(
                    ['name' => $name],
                    ['role' => 'person'],
                );

                $movie->people()->attach($person->id, ['role' => $role]);
            }
        }

        return redirect()
            ->route('admin.movies.index')
            ->with('status', 'Movie created successfully.');
    }

    public function edit(Movie $movie): View
    {
        return view('admin.movies.edit', [
            'movie' => $movie->load(['genres', 'people']),
            'genres' => Genre::query()->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Movie $movie): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'genre_ids' => ['required', 'array', 'min:1'],
            'genre_ids.*' => ['integer', 'exists:genres,id'],
            'rating' => ['nullable', 'numeric', 'between:0,10'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'directors' => ['nullable', 'string', 'max:2000'],
            'cast_members' => ['nullable', 'string', 'max:5000'],
            'body' => ['nullable', 'string'],
        ]);

        $genres = Genre::query()->whereKey($validated['genre_ids'])->get();
        $directors = $this->creditNames($validated['directors'] ?? null);
        $movieData = [
            'title' => $validated['title'],
            'director' => $directors[0] ?? null,
            'genre' => $genres->pluck('name')->join(', '),
            'rating' => $validated['rating'],
            'body' => $validated['body'],
        ];

        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('movies', 'public');

            $this->deleteStoredPoster($movie->poster);

            $movieData['poster'] = Storage::url($thumbnailPath);
        }

        $movie->update($movieData);
        $movie->genres()->sync($genres->modelKeys());
        $this->syncCredits($movie, $directors, $this->creditNames($validated['cast_members'] ?? null));

        return redirect()
            ->route('admin.movies.index')
            ->with('status', 'Movie updated successfully.');
    }

    public function delete(Movie $movie): View
    {
        return view('admin.movies.delete', [
            'movie' => $movie,
        ]);
    }

    public function destroy(Movie $movie): RedirectResponse
    {
        $this->deleteStoredPoster($movie->poster);
        $movie->delete();

        return redirect()
            ->route('admin.movies.index')
            ->with('status', 'Movie deleted successfully.');
    }

    /**
     * @param  list<string>  $directors
     * @param  list<string>  $castMembers
     */
    private function syncCredits(Movie $movie, array $directors, array $castMembers): void
    {
        $credits = [];

        foreach (['director' => $directors, 'cast' => $castMembers] as $role => $names) {
            foreach ($names as $name) {
                $person = Person::query()->firstOrCreate(
                    ['name' => $name],
                    ['role' => 'person'],
                );

                $credits[$person->id] = ['role' => $role];
            }
        }

        $movie->people()->sync($credits);
    }

    private function deleteStoredPoster(?string $poster): void
    {
        if (filled($poster) && Str::startsWith($poster, '/storage/')) {
            Storage::disk('public')->delete(Str::after($poster, '/storage/'));
        }
    }

    /**
     * @return list<string>
     */
    private function creditNames(?string $names): array
    {
        return array_values(array_unique(array_filter(array_map(
            'trim',
            preg_split('/\r\n|\r|\n/', $names ?? '') ?: [],
        ))));
    }
}
