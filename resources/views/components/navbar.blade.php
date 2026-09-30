<header class="sticky top-0 z-40 border-b border-line/60 bg-ink/90 backdrop-blur">
    <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-4 px-4 py-4 sm:px-6">
        <a href="{{ route('movies.index') }}" class="flex items-center gap-2 text-lg font-semibold tracking-tight text-white">
            <span class="inline-flex size-8 items-center justify-center rounded-md bg-gold text-ink">C</span>
            CineMatch
        </a>

        <button
            type="button"
            data-nav-toggle
            class="inline-flex items-center rounded-md border border-line px-3 py-2 text-sm text-white md:hidden"
            aria-label="Toggle navigation">
            Menu
        </button>

        <nav data-nav-menu class="hidden w-full md:block md:w-auto">
            <ul class="flex flex-col gap-3 md:flex-row md:items-center md:gap-6">
                <li>
                    <a href="{{ route('movies.index') }}" class="text-sm text-mist transition hover:text-gold">Movies</a>
                </li>
                <li>
                    <a href="{{ route('movies.favorites') }}" class="text-sm text-mist transition hover:text-gold">Fan favourites</a>
                </li>
                <li>
                    <a href="{{ route('login') }}" class="text-sm text-mist transition hover:text-gold">Login</a>
                </li>
                <li>
                    <x-ui.button href="{{ route('register') }}">Register</x-ui.button>
                </li>
            </ul>
        </nav>
    </div>
</header>