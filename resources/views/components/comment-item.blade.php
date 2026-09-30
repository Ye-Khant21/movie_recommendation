@props(['author', 'time', 'body'])

<article {{ $attributes->merge(['class' => 'rounded-lg border border-line/70 bg-panel p-4']) }}>
    <div class="flex items-center justify-between gap-3">
        <p class="font-medium text-white">{{ $author }}</p>
        <p class="text-xs text-mist/60">{{ $time }}</p>
    </div>
    <p class="mt-2 text-sm leading-relaxed text-mist">{{ $body }}</p>
</article>
