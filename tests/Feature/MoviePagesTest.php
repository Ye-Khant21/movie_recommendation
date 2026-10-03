<?php

use App\Models\Movie;
use App\Models\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('renders database movies in the catalog', function () {
    Movie::factory()->create([
        'title' => 'Neon Harbor',
        'director' => 'Ava Chen',
        'genre' => 'Sci-Fi',
        'rating' => 10.0,
    ]);

    $response = $this->get(route('movies.index'));

    $response
        ->assertOk()
        ->assertSee('Search movies')
        ->assertSee('Neon Harbor')
        ->assertSee('Director Ava Chen')
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

it('returns 404 for a movie that does not exist', function () {
    $this->get(route('movies.show', 999))->assertNotFound();
});

it('renders the login, register, and fan favourites pages', function () {
    $this->get(route('login'))->assertOk()->assertSee('Welcome back');
    $this->get(route('register'))->assertOk()->assertSee('Join CineMatch');
    $this->get(route('movies.favorites'))->assertOk()->assertSee('Fan favourites');
});
