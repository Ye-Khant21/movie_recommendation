@props(['title' => 'Admin', 'heading' => 'Movie dashboard', 'eyebrow' => 'Administration'])

<x-layouts.app :title="$title">
    <div class="mx-auto grid max-w-7xl gap-6 px-4 py-8 sm:px-6 lg:grid-cols-[15rem_minmax(0,1fr)] lg:py-10">
        <aside class="flex h-fit flex-col gap-6 rounded-2xl border border-line/70 bg-panel/80 p-5 shadow-lg shadow-black/15 lg:sticky lg:top-24">
            <div class="flex flex-col gap-1">
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-gold">Admin area</p>
                <p class="text-lg font-semibold text-white">CineMatch</p>
            </div>

            <nav aria-label="Admin navigation">
                <ul class="flex flex-col gap-2">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" @class(['flex rounded-xl px-3 py-2.5 text-sm font-medium transition', 'bg-gold text-ink' => request()->routeIs('admin.dashboard', 'admin.movies.index'), 'text-mist hover:bg-ink-soft hover:text-white' => ! request()->routeIs('admin.dashboard', 'admin.movies.index')])>
                            All movies
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.movies.create') }}" @class(['flex rounded-xl px-3 py-2.5 text-sm font-medium transition', 'bg-gold text-ink' => request()->routeIs('admin.movies.create'), 'text-mist hover:bg-ink-soft hover:text-white' => ! request()->routeIs('admin.movies.create')])>
                            Create movie
                        </a>
                    </li>
                </ul>
            </nav>

            <a href="{{ route('movies.index') }}" class="text-sm text-mist/70 transition hover:text-gold">← Back to catalog</a>
        </aside>

        <div class="flex min-w-0 flex-col gap-8">
            <header class="flex flex-col gap-3 border-b border-line/60 pb-6 sm:flex-row sm:items-end sm:justify-between">
                <div class="flex flex-col gap-2">
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-gold">{{ $eyebrow }}</p>
                    <h1 class="text-3xl font-semibold tracking-tight text-white sm:text-4xl">{{ $heading }}</h1>
                </div>
                <span class="w-fit rounded-full border border-gold/30 bg-gold/10 px-3 py-1 text-xs font-medium text-gold">UI preview</span>
            </header>

            {{ $slot }}
        </div>
    </div>
</x-layouts.app>
