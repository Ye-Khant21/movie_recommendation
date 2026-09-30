<x-layouts.app :title="$movie['title']">
    <div class="relative">
        <div class="absolute inset-0 max-h-[28rem] overflow-hidden">
            <img src="{{ $movie['backdrop'] }}" alt="" class="size-full object-cover opacity-30">
            <div class="absolute inset-0 bg-linear-to-b from-ink/40 to-ink"></div>
        </div>

        <div class="relative mx-auto flex max-w-6xl flex-col gap-10 px-4 py-10 sm:px-6">
            <a href="{{ route('movies.index') }}" class="text-sm text-mist transition hover:text-gold">← All movies</a>

            <section class="grid gap-8 lg:grid-cols-[16rem_1fr]">
                <img
                    src="{{ $movie['poster'] }}"
                    alt="{{ $movie['title'] }} poster"
                    class="w-full max-w-64 justify-self-start rounded-xl border border-line/70 object-cover shadow-2xl"
                >

                <div class="flex flex-col gap-4">
                    <div class="flex flex-wrap items-center gap-3">
                        <x-rating-badge :rating="$movie['rating']" />
                        <span class="text-sm text-mist/70">{{ $movie['year'] }} · {{ $movie['genre'] }} · {{ $movie['runtime'] }}</span>
                    </div>
                    <h1 class="text-4xl font-semibold text-white">{{ $movie['title'] }}</h1>
                    <p class="text-lg text-gold">Director {{ $movie['director'] }}</p>
                    <p class="max-w-2xl leading-relaxed text-mist">{{ $movie['synopsis'] }}</p>
                    <div class="flex flex-wrap gap-3">
                        <x-like-button :movie-id="$movie['id']" :liked="in_array($movie['id'], $likedMovieIds, true)" />
                        <x-ui.button href="#comments" variant="secondary">Read comments</x-ui.button>
                    </div>
                </div>
            </section>

            <section id="comments" class="flex flex-col gap-4">
                <h2 class="text-2xl font-semibold text-white">Comments</h2>
                <div class="flex flex-col gap-3">
                    @forelse ($movie['comments'] as $comment)
                        <x-comment-item
                            :author="$comment['author']"
                            :time="$comment['time']"
                            :body="$comment['body']"
                        />
                    @empty
                        <p class="text-sm text-mist/70">No comments yet. Be the first.</p>
                    @endforelse
                </div>
                <x-comment-form />
            </section>
        </div>
    </div>
</x-layouts.app>
