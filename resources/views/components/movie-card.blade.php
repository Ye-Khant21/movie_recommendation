@props(['movie', 'liked' => false])

<article class="group overflow-hidden rounded-xl border border-line/70 bg-panel shadow-lg">
    <a href="{{ route('movies.show', $movie['id']) }}" class="block">
        <div class="relative aspect-2/3 overflow-hidden">
            <img
                src="{{ $movie['poster'] }}"
                alt="{{ $movie['title'] }} poster"
                class="size-full object-cover transition duration-300 group-hover:scale-105"
            >
            <div class="absolute top-3 right-3">
                <x-rating-badge :rating="$movie['rating']" />
            </div>
        </div>
        <div class="flex flex-col gap-1 p-4">
            <h2 class="text-base font-semibold text-white">{{ $movie['title'] }}</h2>
            <p class="text-sm text-mist/80">Director {{ $movie['director'] }}</p>
            <p class="text-xs text-mist/60">{{ $movie['year'] }} · {{ $movie['genre'] }}</p>
        </div>
    </a>
    <div class="px-4 pb-4">
        <x-like-button :movie-id="$movie['id']" :liked="$liked" />
    </div>
</article>
