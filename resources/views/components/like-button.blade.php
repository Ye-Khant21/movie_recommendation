@props(['movieId', 'liked' => false])

<form method="POST" action="{{ route('movies.like', $movieId) }}">
    @csrf
    <button
        type="submit"
        @class([
            'inline-flex items-center gap-2 rounded-md border px-3 py-2 text-sm font-medium transition',
            'border-gold bg-gold text-ink hover:bg-gold-deep' => $liked,
            'border-line bg-transparent text-white hover:border-gold hover:text-gold' => ! $liked,
        ])
    >
        <svg class="size-4" viewBox="0 0 24 24" fill="{{ $liked ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
        </svg>
        {{ $liked ? 'Liked' : 'Like' }}
    </button>
</form>
