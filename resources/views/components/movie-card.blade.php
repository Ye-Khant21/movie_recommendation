@props(['movie', 'liked' => false])

@php
    $posterUrl = $movie->poster ?: 'https://www.primevideo.com/-/hi/detail/0P5699HX4S6UTRBOYYMCIGWTK3.jpg/ref=atv_hm_hom_c_8pXz9d_2_1';
@endphp

<article class="group overflow-hidden rounded-2xl border border-line/70 bg-panel/80 shadow-lg shadow-black/15 transition duration-300 hover:-translate-y-1 hover:border-gold/60 hover:shadow-xl hover:shadow-black/25">
    <a href="{{ route('movies.show', $movie) }}" class="block">
        <div class="relative aspect-2/3 overflow-hidden">
            <img
                src="{{ $posterUrl }}"
                alt="{{ $movie->title }} poster"
                class="size-full object-cover transition duration-300 group-hover:scale-105"
            >
            <div class="absolute top-3 right-3">
                <x-rating-badge :rating="$movie->rating" />
            </div>
        </div>
        <div class="flex flex-col gap-1.5 p-5">
            <h2 class="text-base font-semibold tracking-tight text-white">{{ $movie->title }}</h2>
            <p class="text-sm text-mist/80">Director {{ $movie->director ?? 'Not listed' }}</p>
            <p class="text-xs text-mist/60">{{ $movie->genre }}</p>
        </div>
    </a>
    <div class="px-5 pb-5">
        <x-like-button :movie-id="$movie->id" :liked="$liked" />
    </div>
</article>
