<section class="rounded-2xl border border-gold/30 bg-linear-to-r from-ink-soft to-panel p-6 sm:p-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex flex-col gap-2">
            <p class="text-sm font-medium uppercase tracking-wider text-gold">Curated picks</p>
            <h2 class="text-2xl font-semibold text-white">Your fan favourites are waiting</h2>
            <p class="max-w-xl text-sm text-mist/80">Keep the movies you love close and revisit your all-time 10/10 list any time.</p>
        </div>
        <x-ui.button href="{{ route('movies.favorites') }}">View favourites</x-ui.button>
    </div>
</section>