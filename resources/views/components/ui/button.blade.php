@props(['type' => 'submit'])
<button type="{{ $type }}" {{ $attributes->merge(['class' => 'inline-flex items-center justify-center rounded-md bg-gold px-4 py-2 text-sm font-semibold text-ink transition hover:bg-gold-deep']) }}>
    {{ $slot }}
</button>
