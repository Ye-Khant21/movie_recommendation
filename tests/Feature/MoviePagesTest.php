<?php

use App\Models\Movie;
use App\Models\Person;
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
        ->assertSee('Cast')
        ->assertSee('Maya Reed')
        ->assertSee('Actress')
        ->assertSee('Like');
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

    $responseByActor = $this->get(route('movies.index', ['search' => 'Leonardo']));
    $responseByActor
        ->assertOk()
        ->assertSee('Inception')
        ->assertDontSee('Pulp Fiction');
});

it('returns 404 for a movie that does not exist', function () {
    $this->get(route('movies.show', 999))->assertNotFound();
});

it('renders the login, register, and fan favourites pages', function () {
    $this->get(route('login'))->assertOk()->assertSee('Welcome back');
    $this->get(route('register'))->assertOk()->assertSee('Join CineMatch');
    $this->get(route('movies.favorites'))->assertOk()->assertSee('Fan favourites');
});
