<footer class="mt-16 border-t border-line/60">
    <div class="mx-auto flex max-w-6xl flex-col gap-3 px-4 py-8 text-sm text-mist/80 sm:flex-row sm:items-center sm:justify-between sm:px-6">
        <p>CineMatch · curated 10/10 recommendations</p>
        <div class="flex gap-4">
            <a href="{{ route('movies.index') }}" class="hover:text-gold">All movies</a>
            <a href="{{ route('movies.favorites') }}" class="hover:text-gold">Fan favourites</a>
        </div>
    </div>
</footer>