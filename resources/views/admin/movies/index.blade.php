<x-admin.layout title="Admin movies" heading="Movie dashboard" eyebrow="Movie management">
    <section class="grid gap-4 sm:grid-cols-3">
        <div class="rounded-2xl border border-line/70 bg-panel p-5 shadow-lg shadow-black/10">
            <p class="text-sm text-mist/70">Movies in catalog</p>
            <p class="mt-2 text-3xl font-semibold text-white">{{ $movies->total() }}</p>
        </div>
        <div class="rounded-2xl border border-line/70 bg-panel p-5 shadow-lg shadow-black/10">
            <p class="text-sm text-mist/70">Drafts</p>
            <p class="mt-2 text-3xl font-semibold text-white">0</p>
        </div>
        <div class="rounded-2xl border border-line/70 bg-panel p-5 shadow-lg shadow-black/10">
            <p class="text-sm text-mist/70">Average rating</p>
            <p class="mt-2 text-3xl font-semibold text-white">8.9</p>
        </div>
    </section>

    <section class="flex flex-col gap-5 rounded-2xl border border-line/70 bg-panel/80 p-5 shadow-lg shadow-black/10 sm:p-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-white">Catalog movies</h2>
                <p class="mt-1 text-sm text-mist/70">Movies currently in your catalog.</p>
            </div>
            <a href="{{ route('admin.movies.create') }}" class="inline-flex items-center justify-center rounded-lg bg-gold px-4 py-2 text-sm font-semibold text-ink shadow-lg shadow-gold/15 transition hover:bg-gold-deep">
                Create movie
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[42.5rem] text-left text-sm">
                <thead class="border-b border-line text-xs uppercase tracking-wider text-mist/60">
                    <tr>
                        <th class="px-3 py-3 font-medium">Movie</th>
                        <th class="px-3 py-3 font-medium">Genre</th>
                        <th class="px-3 py-3 font-medium">Director</th>
                        <th class="px-3 py-3 font-medium">Rating</th>
                        <th class="px-3 py-3 text-right font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($movies as $movie)
                        <tr class="border-b border-line/50 last:border-0">
                            <td class="px-3 py-4 font-medium text-white">{{ $movie->title }}</td>
                            <td class="px-3 py-4 text-mist">{{ $movie->genres->pluck('name')->join(', ') ?: $movie->genre }}</td>
                            <td class="px-3 py-4 text-mist">{{ $movie->director }}</td>
                            <td class="px-3 py-4 text-mist">{{ $movie->rating }}/10</td>
                            <td class="px-3 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.movies.edit', $movie) }}" class="rounded-lg border border-line px-3 py-1.5 text-xs font-medium text-mist transition hover:border-gold hover:text-gold">Edit</a>
                                    <a href="{{ route('admin.movies.delete', $movie) }}" class="rounded-lg border border-red-400/40 px-3 py-1.5 text-xs font-medium text-red-300 transition hover:bg-red-400/10">Delete</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($movies->hasPages())
            <nav class="flex items-center justify-between gap-3 border-t border-line/60 pt-5 text-sm" aria-label="Movie pagination">
                @if ($movies->onFirstPage())
                    <span class="rounded-lg border border-line/60 px-3 py-2 text-mist/40">Previous</span>
                @else
                    <a href="{{ $movies->previousPageUrl() }}" class="rounded-lg border border-line px-3 py-2 text-mist transition hover:border-gold hover:text-white">Previous</a>
                @endif

                <span class="text-mist/70">Page {{ $movies->currentPage() }} of {{ $movies->lastPage() }}</span>

                @if ($movies->hasMorePages())
                    <a href="{{ $movies->nextPageUrl() }}" class="rounded-lg border border-line px-3 py-2 text-mist transition hover:border-gold hover:text-white">Next</a>
                @else
                    <span class="rounded-lg border border-line/60 px-3 py-2 text-mist/40">Next</span>
                @endif
            </nav>
        @endif
    </section>
</x-admin.layout>
