<x-layouts.app :title="$movie->title">
    @php
        $posterUrl = $movie->poster ?: 'https://www.primevideo.com/-/hi/detail/0P5699HX4S6UTRBOYYMCIGWTK3.jpg/ref=atv_hm_hom_c_8pXz9d_2_1';
        $directors = $movie->people->filter(fn ($person) => $person->pivot->role === 'director')->pluck('name');
        $cast = $movie->people->filter(fn ($person) => $person->pivot->role === 'cast');
        $genres = $movie->genres->pluck('name')->join(' · ') ?: $movie->genre;
    @endphp

    <div class="relative">
        <div class="absolute inset-0 max-h-[28rem] overflow-hidden">
            <img src="{{ $posterUrl }}" alt="" class="size-full object-cover opacity-30">
            <div class="absolute inset-0 bg-linear-to-b from-ink/40 to-ink"></div>
        </div>

        <div class="relative mx-auto flex max-w-6xl flex-col gap-12 px-4 py-12 sm:px-6">
            <a href="{{ route('movies.index') }}" class="text-sm text-mist transition hover:text-gold">← All movies</a>

            <section class="grid gap-8 lg:grid-cols-[16rem_1fr]">
                <img
                    src="{{ $posterUrl }}"
                    alt="{{ $movie->title }} poster"
                    class="w-full max-w-64 justify-self-start rounded-2xl border border-line/70 object-cover shadow-2xl shadow-black/30"
                >

                <div class="flex flex-col gap-4">
                    <div class="flex flex-wrap items-center gap-3">
                        <x-rating-badge :rating="$movie->rating" />
                        <span class="text-sm text-mist/70">{{ $genres }}</span>
                    </div>
                    <h1 class="text-4xl font-semibold tracking-tight text-white sm:text-5xl">{{ $movie->title }}</h1>
                    <p class="text-lg text-gold">Director {{ $directors->join(', ') ?: ($movie->director ?? 'Not listed') }}</p>
                    <div class="flex flex-wrap gap-3">
                        <x-like-button :movie-id="$movie->id" :liked="in_array($movie->id, $likedMovieIds, true)" />
                    </div>
                </div>
            </section>

            <section class="flex flex-col gap-4" aria-labelledby="about-heading">
                <h2 id="about-heading" class="text-2xl font-semibold text-white">About</h2>
                @if (filled($movie->body))
                    <p class="max-w-3xl whitespace-pre-wrap text-base leading-7 text-mist/85">{{ $movie->body }}</p>
                @else
                    <p class="text-sm text-mist/70">No description has been added yet.</p>
                @endif
            </section>

            <section class="flex flex-col gap-4">
                <h2 class="text-2xl font-semibold text-white">Cast</h2>
                <div class="flex flex-wrap gap-3">
                    @forelse ($cast as $person)
                        <span class="rounded-full border border-line bg-panel px-3.5 py-2 text-sm text-mist">
                            {{ $person->name }}@if (filled($person->pivot->character_name)) · {{ $person->pivot->character_name }}@endif
                        </span>
                    @empty
                        <p class="text-sm text-mist/70">No cast members have been added yet.</p>
                    @endforelse
                </div>
            </section>

            <section class="flex flex-col gap-6 border-t border-line/60 pt-10" aria-labelledby="comments-heading">
                <div class="flex flex-wrap items-end justify-between gap-3">
                    <div class="flex flex-col gap-1">
                        <h2 id="comments-heading" class="text-2xl font-semibold text-white">Comments</h2>
                        <p class="text-sm text-mist/70">What other viewers are saying.</p>
                    </div>
                    <span class="rounded-full border border-line bg-panel px-3 py-1 text-xs font-medium text-mist">
                        {{ $movie->comments->count() }} {{ Str::plural('comment', $movie->comments->count()) }}
                    </span>
                </div>

                <div class="grid items-start gap-8 lg:grid-cols-[minmax(0,1fr)_22rem]">
                    <div class="flex flex-col gap-3">
                        @forelse ($movie->comments as $comment)
                            <x-comment-item
                                :author="$comment->user->name"
                                :time="$comment->created_at->diffForHumans()"
                                :body="$comment->content"
                                :can-manage="false"
                            />
                        @empty
                            <div class="rounded-xl border border-dashed border-line/80 bg-panel/60 px-5 py-10 text-center">
                                <p class="font-medium text-white">No comments yet</p>
                                <p class="mt-1 text-sm text-mist/70">Be the first to share your take on this movie.</p>
                            </div>
                        @endforelse
                    </div>

                    <x-comment-form :movie="$movie" class="lg:sticky lg:top-6" />
                </div>
            </section>
        </div>
    </div>
</x-layouts.app>
