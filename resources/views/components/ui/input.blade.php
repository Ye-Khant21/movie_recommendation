@props([
    'label',
    'name',
    'type' => 'text',
    'id' => null,
])

@php
    $id ??= $name;
@endphp

<div class="flex flex-col gap-2">
    <label for="{{ $id }}" class="text-sm font-medium text-white">{{ $label }}</label>
    <input
        id="{{ $id }}"
        name="{{ $name }}"
        type="{{ $type }}"
        {{ $attributes->merge(['class' => 'w-full rounded-md border border-line bg-ink px-3 py-2 text-sm text-white outline-none placeholder:text-mist/40 focus:border-gold']) }}
    >
</div>
