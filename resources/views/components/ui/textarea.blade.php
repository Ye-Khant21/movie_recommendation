@props([
    'label',
    'name',
    'id' => null,
    'rows' => 4,
])

@php
    $id ??= $name;
@endphp

<div class="flex flex-col gap-2">
    <label for="{{ $id }}" class="text-sm font-medium text-white">{{ $label }}</label>
    <textarea
        id="{{ $id }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        {{ $attributes->merge(['class' => 'w-full rounded-md border border-line bg-ink px-3 py-2 text-sm text-white outline-none placeholder:text-mist/40 focus:border-gold']) }}
    ></textarea>
</div>
