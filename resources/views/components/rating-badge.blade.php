@props(['rating' => '10/10'])

<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-full bg-gold px-2.5 py-1 text-xs font-semibold text-ink shadow-sm shadow-gold/20']) }}>
    {{ $rating }}
</span>
