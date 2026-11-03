@props(['movie'])

<form {{ $attributes->merge(['class' => 'flex h-fit flex-col gap-4 rounded-xl border border-line/70 bg-panel p-5']) }} action="{{ route('movies.comment', $movie) }}" method="POST">
    @csrf
    <div class="flex flex-col gap-1">
        <h3 class="text-lg font-semibold text-white">Leave a comment</h3>
        @auth
            <p class="text-sm text-mist/70">
                Commenting as <span class="font-medium text-white">{{ auth()->user()->name }}</span>
            </p>
        @else
            <p class="text-sm text-mist/70">Log in to share what you thought of this film.</p>
        @endauth
    </div>

    @auth
        <x-ui.textarea name="content" label="Comment" placeholder="What did you think?" required>{{ old('content') }}</x-ui.textarea>
        @error('content')
            <p class="text-sm text-red-400">{{ $message }}</p>
        @enderror
        <x-ui.button type="submit">Post comment</x-ui.button>
        @if (session('status'))
            <p class="text-sm text-gold">{{ session('status') }}</p>
        @endif
    @else
        <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-lg bg-gold px-4 py-2 text-sm font-semibold text-ink shadow-lg shadow-gold/15 transition hover:bg-gold-deep">
            Log in to comment
        </a>
    @endauth
</form>
