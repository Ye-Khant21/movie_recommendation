<x-layouts.app title="All movies">
    <div class="mx-auto flex max-w-6xl flex-col gap-12 px-4 py-12 sm:px-6">
        <section class="flex flex-col items-center gap-6 border-b border-line/60 pb-12 pt-6 text-center sm:pt-10">
            <div class="flex max-w-2xl flex-col items-center gap-3">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gold">CineMatch · curated for you</p>
                <h1 class="text-4xl font-semibold leading-tight tracking-tight text-white sm:text-5xl">Find your next <span class="text-gold">favorite film.</span></h1>
                <p class="max-w-lg text-base leading-7 text-mist/75">Explore standout stories, handpicked for your next great movie night.</p>
            </div>

            <div class="w-full max-w-xl">
                <label for="movie-search" class="mb-2 block text-left text-sm font-medium text-mist">Search the catalog</label>
                <form action="{{ route('movies.index') }}" method="GET" class="flex gap-2">
                    <input
                        id="movie-search"
                        name="search"
                        type="search"
                        placeholder="Search by title, director, or genre"
                        class="h-12 w-full rounded-xl border border-line bg-ink-soft px-4 text-base text-white shadow-sm shadow-black/20 placeholder:text-mist/50 transition focus:border-gold focus:outline-none focus:ring-4 focus:ring-gold/15"
                        aria-label="Search movies"
                        value="{{ request('search') }}">
                    <button type="submit" class="h-12 rounded-xl bg-gold px-6 font-semibold text-ink transition hover:bg-gold-light">
                        Search
                    </button>
                </form>
            </div>
        </section>

        <section class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($movies as $movie)
            <x-movie-card :movie="$movie" :liked="in_array($movie->id, $likedMovieIds, true)" />
            @endforeach
        </section>
    </div>
</x-layouts.app>