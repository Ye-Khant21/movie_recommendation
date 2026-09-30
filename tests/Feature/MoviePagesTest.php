<?php

it('renders the movie catalog with ratings and directors', function () {
    $response = $this->get(route('movies.index'));

    $response->assertOk();
    $response->assertSee('Search movies');
    $response->assertSee('Neon Harbor');
    $response->assertSee('Director Ava Chen');
    $response->assertSee('10/10');
    $response->assertDontSee('Subscribe');
});

it('renders a movie detail page with comments and like actions', function () {
    $response = $this->get(route('movies.show', 1));

    $response->assertOk();
    $response->assertSee('Neon Harbor');
    $response->assertSee('Director Ava Chen');
    $response->assertSee('Leave a comment');
    $response->assertSee('Like');
});

it('returns 404 for a movie that is not in the catalog', function () {
    $this->get(route('movies.show', 999))->assertNotFound();
});

it('renders the login, register, and fan favourites pages', function () {
    $this->get(route('login'))->assertOk()->assertSee('Welcome back');
    $this->get(route('register'))->assertOk()->assertSee('Join CineMatch');
    $this->get(route('movies.favorites'))->assertOk()->assertSee('Fan favourites');
});
