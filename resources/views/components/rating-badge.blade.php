@props(['rating' => '10/10'])

<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-full bg-gold px-2.5 py-1 text-xs font-semibold text-ink']) }}>
    {{ $rating }}
</span>
