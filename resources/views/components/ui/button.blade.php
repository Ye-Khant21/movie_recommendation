@props([
    'href' => null,
    'type' => 'button',
    'variant' => 'primary',
])

@php
    $classes = match ($variant) {
        'secondary' => 'inline-flex items-center justify-center rounded-md border border-line bg-transparent px-4 py-2 text-sm font-medium text-white transition hover:border-gold hover:text-gold',
        'ghost' => 'inline-flex items-center justify-center rounded-md px-3 py-2 text-sm font-medium text-mist transition hover:text-gold',
        default => 'inline-flex items-center justify-center rounded-md bg-gold px-4 py-2 text-sm font-semibold text-ink transition hover:bg-gold-deep',
    };
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
