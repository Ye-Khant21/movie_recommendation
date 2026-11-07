<x-admin.layout title="Delete movie" heading="Delete movie" eyebrow="Movie management">
    <section class="max-w-2xl rounded-2xl border border-red-400/35 bg-panel/80 p-5 shadow-lg shadow-black/10 sm:p-6">
        <p class="text-sm font-semibold uppercase tracking-[0.16em] text-red-300">Delete confirmation</p>
        <h2 class="mt-3 text-2xl font-semibold text-white">Delete {{ $movie->title }}?</h2>
        <p class="mt-3 leading-7 text-mist/80">This permanently removes the movie from your catalog. This action cannot be undone.</p>

        <div class="mt-6 flex items-center gap-4 rounded-xl border border-line/70 bg-ink-soft p-4">
            <img src="{{ $movie->poster }}" alt="{{ $movie->title }} poster" class="size-14 rounded-lg object-cover">
            <div>
                <p class="font-medium text-white">{{ $movie->title }}</p>
                <p class="text-sm text-mist/70">{{ $movie->director }} · {{ $movie->genre }}</p>
            </div>
        </div>

        <form action="{{ route('admin.movies.destroy', $movie) }}" method="POST" class="mt-7 flex flex-wrap gap-3">
            @csrf
            @method('DELETE')

            <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-red-400 px-4 py-2 text-sm font-semibold text-ink transition hover:bg-red-300">Delete movie</button>
            <a href="{{ route('admin.movies.index') }}" class="inline-flex items-center justify-center rounded-lg border border-line px-4 py-2 text-sm font-medium text-mist transition hover:border-gold hover:text-white">Cancel</a>
        </form>
    </section>
</x-admin.layout>
