@props(['name', 'price', 'featured' => false])

<article @class([
    'flex flex-col gap-4 rounded-2xl border p-6',
    'border-gold bg-panel shadow-lg shadow-gold/10' => $featured,
    'border-line/70 bg-ink-soft' => ! $featured,
])>
    <div class="flex flex-col gap-1">
        <h2 class="text-lg font-semibold text-white">{{ $name }}</h2>
        <p class="text-3xl font-semibold text-gold">{{ $price }}</p>
    </div>
    <ul class="flex flex-col gap-2 text-sm text-mist/80">
        {{ $slot }}
    </ul>
    <x-ui.button type="submit" class="mt-auto">Choose {{ $name }}</x-ui.button>
</article>
