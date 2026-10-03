<x-layouts.app title="Fan favourites">
    <div class="mx-auto flex max-w-6xl flex-col gap-8 px-4 py-10 sm:px-6">
        <section class="flex flex-col gap-3">
            <p class="text-sm font-medium uppercase tracking-wider text-gold">Your picks</p>
            <h1 class="text-3xl font-semibold text-white sm:text-4xl">Fan favourites</h1>
            <p class="max-w-2xl text-mist/80">The films you’ve liked are collected here for quick access to your top-tier queue.</p>
        </section>

        @if ($movies->isEmpty())
        <div class="rounded-2xl border border-dashed border-line bg-panel p-8 text-center">
            <h2 class="text-xl font-semibold text-white">No favourites yet</h2>
            <p class="mt-2 text-mist/80">Head back to the catalog and like a few movies to build your personal 10/10 shelf.</p>
            <div class="mt-5">
                <x-ui.button href="{{ route('movies.index') }}">Browse movies</x-ui.button>
            </div>
        </div>
        @else
        <section class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($movies as $movie)
            <x-movie-card :movie="$movie" :liked="in_array($movie->id, $likedMovieIds, true)" />
            @endforeach
        </section>
        @endif
    </div>
</x-layouts.app>
