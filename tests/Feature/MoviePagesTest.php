<?php

use App\Models\Movie;
use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('renders database movies with actors and actresses in the catalog', function () {
    $movie = Movie::factory()->create([
        'title' => 'Neon Harbor',
        'director' => 'Ava Chen',
        'genre' => 'Sci-Fi',
        'rating' => 10.0,
    ]);

    $actor = Person::factory()->create(['name' => 'Leo Vance', 'role' => 'actor']);
    $actress = Person::factory()->create(['name' => 'Maya Reed', 'role' => 'actress']);

    $movie->people()->attach([$actor->id, $actress->id]);

    $response = $this->get(route('movies.index'));

    $response
        ->assertOk()
        ->assertSee('Search movies')
        ->assertSee('Neon Harbor')
        ->assertSee('Director Ava Chen')
        ->assertSee('Actor:')
        ->assertSee('Leo Vance')
        ->assertSee('Actress:')
        ->assertSee('Maya Reed')
        ->assertSee('10.0');
});

it('renders a database movie with its cast on the detail page', function () {
    $movie = Movie::factory()->create([
        'title' => 'Neon Harbor',
        'director' => 'Ava Chen',
        'genre' => 'Sci-Fi',
        'rating' => 10.0,
        'body' => 'A rain-soaked port city hides a smuggling ring that trades in stolen memories.',
    ]);
    $person = Person::factory()->create([
        'name' => 'Maya Reed',
        'role' => 'actress',
    ]);
    $movie->people()->attach($person);

    $response = $this->get(route('movies.show', $movie));

    $response
        ->assertOk()
        ->assertSee('Neon Harbor')
        ->assertSee('Director Ava Chen')
        ->assertSee('About')
        ->assertSee('A rain-soaked port city hides a smuggling ring that trades in stolen memories.')
        ->assertSee('Cast')
        ->assertSee('Maya Reed')
        ->assertSee('Actress')
        ->assertSee('Log in to like');
});

it('can filter movies by director, title, genre, or actor name', function () {
    $movie1 = Movie::factory()->create([
        'title' => 'Inception',
        'director' => 'Christopher Nolan',
        'genre' => 'Sci-Fi',
    ]);
    $movie2 = Movie::factory()->create([
        'title' => 'Pulp Fiction',
        'director' => 'Quentin Tarantino',
        'genre' => 'Crime',
    ]);

    $actor = Person::factory()->create(['name' => 'Leonardo DiCaprio', 'role' => 'actor']);
    $movie1->people()->attach($actor);

    $responseByDirector = $this->get(route('movies.index', ['search' => 'Nolan']));
    $responseByDirector
        ->assertOk()
        ->assertSee('Inception')
        ->assertDontSee('Pulp Fiction');

    $responseByGenre = $this->get(route('movies.index', ['genre' => 'Crime']));
    $responseByGenre
        ->assertOk()
        ->assertSee('Pulp Fiction')
        ->assertDontSee('Inception');
});

it('returns 404 for a movie that does not exist', function () {
    $this->get(route('movies.show', 999))->assertNotFound();
});

it('stores an authenticated user comment and displays it on the movie page', function () {
    $user = User::factory()->create(['name' => 'Maya Reed']);
    $movie = Movie::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post(route('movies.comment', $movie), ['content' => 'The final scene stayed with me.']);

    $response->assertRedirect(route('movies.show', $movie));
    $this->assertDatabaseHas('comments', [
        'user_id' => $user->id,
        'movie_id' => $movie->id,
        'content' => 'The final scene stayed with me.',
    ]);

    $this->get(route('movies.show', $movie))
        ->assertOk()
        ->assertSee('Maya Reed')
        ->assertSee('The final scene stayed with me.');
});

it('requires authentication before storing a comment', function () {
    $movie = Movie::factory()->create();

    $this->post(route('movies.comment', $movie), ['content' => 'A comment'])
        ->assertRedirect(route('login'));
});

it('requires authentication before liking a movie', function () {
    $movie = Movie::factory()->create();

    $this->post(route('movies.like', $movie))
        ->assertRedirect(route('login'));
});

it('allows an authenticated user to like a movie', function () {
    $user = User::factory()->create();
    $movie = Movie::factory()->create();

    $this->actingAs($user)
        ->post(route('movies.like', $movie))
        ->assertRedirect()
        ->assertSessionHas('liked_movies', [$movie->id]);

    $this->actingAs($user)
        ->get(route('movies.show', $movie))
        ->assertOk()
        ->assertSee('Liked');
});

it('renders the login, register, and fan favourites pages', function () {
    $this->get(route('login'))->assertOk()->assertSee('Welcome back');
    $this->get(route('register'))->assertOk()->assertSee('Join CineMatch');
    $this->get(route('movies.favorites'))->assertOk()->assertSee('Fan favourites');
});
