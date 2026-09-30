@props(['title', 'subtitle' => null])

<section class="mx-auto w-full max-w-md rounded-2xl border border-line/70 bg-panel p-6 sm:p-8">
    <div class="flex flex-col gap-2">
        <h1 class="text-2xl font-semibold text-white">{{ $title }}</h1>
        @if ($subtitle)
            <p class="text-sm text-mist/80">{{ $subtitle }}</p>
        @endif
    </div>
    <div class="mt-6">
        {{ $slot }}
    </div>
</section>
