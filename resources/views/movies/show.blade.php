<x-layouts.app :title="$movie->title">
    <div class="relative">
        <div class="absolute inset-0 max-h-[28rem] overflow-hidden">
            @if ($movie->poster)
                <img src="{{ $movie->poster }}" alt="" class="size-full object-cover opacity-30">
            @endif
            <div class="absolute inset-0 bg-linear-to-b from-ink/40 to-ink"></div>
        </div>

        <div class="relative mx-auto flex max-w-6xl flex-col gap-10 px-4 py-10 sm:px-6">
            <a href="{{ route('movies.index') }}" class="text-sm text-mist transition hover:text-gold">← All movies</a>

            <section class="grid gap-8 lg:grid-cols-[16rem_1fr]">
                @if ($movie->poster)
                    <img
                        src="{{ $movie->poster }}"
                        alt="{{ $movie->title }} poster"
                        class="w-full max-w-64 justify-self-start rounded-xl border border-line/70 object-cover shadow-2xl"
                    >
                @endif

                <div class="flex flex-col gap-4">
                    <div class="flex flex-wrap items-center gap-3">
                        <x-rating-badge :rating="$movie->rating" />
                        <span class="text-sm text-mist/70">{{ $movie->genre }}</span>
                    </div>
                    <h1 class="text-4xl font-semibold text-white">{{ $movie->title }}</h1>
                    <p class="text-lg text-gold">Director {{ $movie->director ?? 'Not listed' }}</p>
                    <div class="flex flex-wrap gap-3">
                        <x-like-button :movie-id="$movie->id" :liked="in_array($movie->id, $likedMovieIds, true)" />
                    </div>
                </div>
            </section>

            <section class="flex flex-col gap-4">
                <h2 class="text-2xl font-semibold text-white">Cast</h2>
                <div class="flex flex-wrap gap-3">
                    @forelse ($movie->people as $person)
                        <span class="rounded-full border border-line bg-panel px-3 py-2 text-sm text-mist">
                            {{ $person->name }} · {{ ucfirst($person->role) }}
                        </span>
                    @empty
                        <p class="text-sm text-mist/70">No cast members have been added yet.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</x-layouts.app>
