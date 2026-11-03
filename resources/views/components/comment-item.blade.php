@props([
    'author',
    'time',
    'body',
    'canManage' => true,
])

<article data-comment-item {{ $attributes->merge(['class' => 'rounded-lg border border-line/70 bg-panel p-4']) }}>
    <div class="flex flex-wrap items-start justify-between gap-3">
        <div class="flex flex-col gap-0.5">
            <p class="font-medium text-white">{{ $author }}</p>
            <p class="text-xs text-mist/60">{{ $time }}</p>
        </div>

        @if ($canManage)
            <div class="flex gap-2">
                <button
                    type="button"
                    data-comment-edit
                    class="rounded-lg border border-line px-3 py-1.5 text-xs font-medium text-mist transition hover:border-gold hover:text-gold"
                >
                    Edit
                </button>
                <button
                    type="button"
                    data-comment-delete
                    class="rounded-lg border border-line px-3 py-1.5 text-xs font-medium text-mist transition hover:border-red-400 hover:text-red-400"
                >
                    Delete
                </button>
            </div>
        @endif
    </div>

    <p data-comment-body class="mt-3 text-sm leading-relaxed text-mist">{{ $body }}</p>

    @if ($canManage)
        @php
            $editorId = 'comment-edit-'.uniqid();
        @endphp

        <form data-comment-editor hidden class="mt-3 flex flex-col gap-3">
            <x-ui.textarea :id="$editorId" name="comment" label="Edit comment" :rows="3">{{ $body }}</x-ui.textarea>
            <div class="flex gap-2">
                <x-ui.button type="submit">Save</x-ui.button>
                <button
                    type="button"
                    data-comment-cancel
                    class="inline-flex items-center justify-center rounded-lg border border-line px-4 py-2 text-sm font-medium text-mist transition hover:border-gold hover:text-white"
                >
                    Cancel
                </button>
            </div>
        </form>
    @endif
</article>
