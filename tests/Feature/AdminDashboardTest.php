<?php

use App\Models\Genre;
use App\Models\Movie;
use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

it('requires login to view the admin dashboard', function () {
    $this->get(route('admin.dashboard'))
        ->assertRedirect(route('login'));
});

it('renders the static admin movie pages for an authenticated user', function () {
    $user = User::factory()->create(['is_admin' => true]);
    $movie = Movie::factory()->create(['title' => 'Neon Harbor']);

    $this->actingAs($user)
        ->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('Movie dashboard')
        ->assertSee('Neon Harbor');

    $this->actingAs($user)
        ->get(route('admin.movies.create'))
        ->assertOk()
        ->assertSee('Create movie')
        ->assertSee('Upload thumbnail')
        ->assertSee('Cast members')
        ->assertSee('Directors');

    $this->actingAs($user)
        ->get(route('admin.movies.edit', $movie))
        ->assertOk()
        ->assertSee('Edit movie');

    $this->actingAs($user)
        ->get(route('admin.movies.delete', $movie))
        ->assertOk()
        ->assertSee('Delete movie');
});

it('forbids non-admin users from the admin dashboard', function () {
    $user = User::factory()->create(['is_admin' => false]);

    $this->actingAs($user)
        ->get(route('admin.dashboard'))
        ->assertForbidden();
});

it('allows an admin to create a movie with a thumbnail and cast', function () {
    Storage::fake('public');

    $admin = User::factory()->create(['is_admin' => true]);
    $sciFi = Genre::factory()->create(['name' => 'Sci-Fi', 'slug' => 'sci-fi']);
    $thriller = Genre::factory()->create(['name' => 'Thriller', 'slug' => 'thriller']);

    $response = $this->actingAs($admin)->post(route('admin.movies.store'), [
        'title' => 'Neon Harbor',
        'genre_ids' => [$sciFi->id, $thriller->id],
        'rating' => 9.4,
        'thumbnail' => UploadedFile::fake()->image('neon-harbor.jpg'),
        'directors' => "Ava Chen\nMarcus Lee",
        'cast_members' => "John Smith\nJane Doe",
        'body' => 'A movie about memories and a rain-soaked port city.',
    ]);

    $response
        ->assertRedirect(route('admin.movies.index'))
        ->assertSessionHas('status', 'Movie created successfully.');

    $movie = Movie::query()->where('title', 'Neon Harbor')->firstOrFail();

    $this->assertDatabaseHas('movies', [
        'id' => $movie->id,
        'director' => 'Ava Chen',
        'genre' => 'Sci-Fi, Thriller',
    ]);
    Storage::disk('public')->assertExists(str_replace('/storage/', '', $movie->poster));
    $this->assertDatabaseHas('genre_movie', ['movie_id' => $movie->id, 'genre_id' => $sciFi->id]);
    $this->assertDatabaseHas('genre_movie', ['movie_id' => $movie->id, 'genre_id' => $thriller->id]);
    $this->assertDatabaseHas('movie_person', ['movie_id' => $movie->id, 'role' => 'director']);
    $this->assertDatabaseHas('movie_person', ['movie_id' => $movie->id, 'role' => 'cast']);
});

it('allows an admin to update a movie, its genres, and its credits', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $action = Genre::factory()->create(['name' => 'Action', 'slug' => 'action']);
    $drama = Genre::factory()->create(['name' => 'Drama', 'slug' => 'drama']);
    $movie = Movie::factory()->create(['title' => 'Old Title']);
    $movie->genres()->attach($action);
    $oldCastMember = Person::factory()->create(['name' => 'Old Cast Member', 'role' => 'person']);
    $movie->people()->attach($oldCastMember, ['role' => 'cast']);

    $response = $this->actingAs($admin)->put(route('admin.movies.update', $movie), [
        'title' => 'New Title',
        'genre_ids' => [$drama->id],
        'rating' => 8.5,
        'directors' => 'Ava Chen',
        'cast_members' => "John Smith\nJane Doe",
        'body' => 'An updated description.',
    ]);

    $response
        ->assertRedirect(route('admin.movies.index'))
        ->assertSessionHas('status', 'Movie updated successfully.');

    $this->assertDatabaseHas('movies', [
        'id' => $movie->id,
        'title' => 'New Title',
        'genre' => 'Drama',
        'director' => 'Ava Chen',
    ]);
    $this->assertDatabaseHas('genre_movie', ['movie_id' => $movie->id, 'genre_id' => $drama->id]);
    $this->assertDatabaseMissing('genre_movie', ['movie_id' => $movie->id, 'genre_id' => $action->id]);
    $this->assertDatabaseHas('movie_person', ['movie_id' => $movie->id, 'role' => 'director']);
    $this->assertDatabaseHas('movie_person', ['movie_id' => $movie->id, 'role' => 'cast']);
    $this->assertDatabaseMissing('movie_person', ['movie_id' => $movie->id, 'person_id' => $oldCastMember->id]);
});

it('allows an admin to delete a movie and its stored thumbnail', function () {
    Storage::fake('public');

    $admin = User::factory()->create(['is_admin' => true]);
    $movie = Movie::factory()->create(['poster' => '/storage/movies/delete-me.jpg']);
    Storage::disk('public')->put('movies/delete-me.jpg', 'thumbnail');

    $response = $this->actingAs($admin)->delete(route('admin.movies.destroy', $movie));

    $response
        ->assertRedirect(route('admin.movies.index'))
        ->assertSessionHas('status', 'Movie deleted successfully.');

    $this->assertModelMissing($movie);
    Storage::disk('public')->assertMissing('movies/delete-me.jpg');
});

it('paginates the admin movie catalog', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    Movie::factory()->count(10)->create();
    Movie::factory()->create([
        'title' => 'Older Movie',
        'created_at' => now()->subDay(),
    ]);

    $this->actingAs($admin)
        ->get(route('admin.movies.index'))
        ->assertOk()
        ->assertSee('Page 1 of 2')
        ->assertSee('Next');

    $this->actingAs($admin)
        ->get(route('admin.movies.index', ['page' => 2]))
        ->assertOk()
        ->assertSee('Page 2 of 2')
        ->assertSee('Older Movie');
});
