<x-layouts.app title="All movies">
    <div class="mx-auto flex max-w-6xl flex-col gap-10 px-4 py-10 sm:px-6">
        <section class="rounded-2xl border border-line/70 bg-panel/80 p-4 shadow-lg sm:p-6">
            <div class="flex items-center gap-3 rounded-xl border border-line bg-ink/60 px-4 py-3 sm:px-5">
                <svg class="size-5 text-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <circle cx="11" cy="11" r="6"></circle>
                    <path d="M16 16L21 21"></path>
                </svg>
                <input
                    type="search"
                    placeholder="Search movies..."
                    class="w-full border-0 bg-transparent text-base text-white placeholder:text-mist/60 focus:outline-none"
                    aria-label="Search movies">
            </div>
        </section>

        <section class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($movies as $movie)
            <x-movie-card :movie="$movie" :liked="in_array($movie['id'], $likedMovieIds, true)" />
            @endforeach
        </section>
    </div>
</x-layouts.app>