<x-layouts.app title="All movies">
    <div class="mx-auto flex max-w-6xl flex-col gap-10 px-4 py-10 sm:px-6">
        <section class="flex flex-col items-center gap-5 border-b border-line/60 pb-10 pt-4 text-center sm:gap-6 sm:pt-8">
            <div class="flex max-w-2xl flex-col items-center gap-3">
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-gold">CineMatch · curated for you</p>
                <h1 class="text-3xl font-semibold leading-tight text-white sm:text-4xl">Find your next <span class="text-gold">favorite film.</span></h1>
                <p class="max-w-lg text-sm leading-6 text-mist/75">Explore standout stories, handpicked for your next great movie night.</p>
            </div>

            <div class="relative w-full max-w-md">
                <svg class="pointer-events-none absolute left-3.5 top-1/2 size-4 -translate-y-1/2 text-mist/60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <circle cx="11" cy="11" r="6"></circle>
                    <path d="M16 16L21 21"></path>
                </svg>
                <input
                    type="search"
                    placeholder="Search movies..."
                    class="h-11 w-full rounded-md border border-line bg-panel pl-10 pr-4 text-sm text-white placeholder:text-mist/60 transition focus:border-gold focus:outline-none focus:ring-2 focus:ring-gold/20"
                    aria-label="Search movies">
            </div>
        </section>

        <section class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($movies as $movie)
            <x-movie-card :movie="$movie" :liked="in_array($movie->id, $likedMovieIds, true)" />
            @endforeach
        </section>
    </div>
</x-layouts.app>
