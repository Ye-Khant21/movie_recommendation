@props(['type' => 'submit'])
<button type="{{ $type }}" {{ $attributes->merge(['class' => 'inline-flex items-center justify-center rounded-lg bg-gold px-4 py-2 text-sm font-semibold text-ink shadow-lg shadow-gold/15 transition hover:bg-gold-deep focus:outline-none focus:ring-4 focus:ring-gold/20']) }}>
    {{ $slot }}
</button>
