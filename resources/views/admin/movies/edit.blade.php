<x-admin.layout title="Edit movie" heading="Edit movie" eyebrow="Movie management">
    @php
        $selectedGenreIds = old('genre_ids', $movie->genres->modelKeys());
        $directorNames = old('directors', $movie->people->filter(fn ($person) => $person->pivot->role === 'director')->pluck('name')->join("\n"));
        $castNames = old('cast_members', $movie->people->filter(fn ($person) => $person->pivot->role === 'cast')->pluck('name')->join("\n"));
    @endphp

    <section class="rounded-2xl border border-line/70 bg-panel/80 p-5 shadow-lg shadow-black/10 sm:p-6">
        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-400/40 bg-red-400/10 px-4 py-3 text-sm text-red-200">
                Please correct the highlighted fields and try again.
            </div>
        @endif

        <form action="{{ route('admin.movies.update', $movie) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid gap-5 md:grid-cols-2">
                <x-ui.input name="title" label="Movie title" :value="old('title', $movie->title)" required />
                <x-ui.input name="rating" type="number" label="Rating" :value="old('rating', $movie->rating)" step="0.1" min="0" max="10" />
                <div class="flex flex-col gap-2 md:col-span-2">
                    <label for="genre_ids" class="text-sm font-medium text-white">Genres</label>
                    <select id="genre_ids" name="genre_ids[]" multiple required class="min-h-36 w-full rounded-md border border-line bg-ink px-3 py-2 text-sm text-white outline-none focus:border-gold">
                        @foreach ($genres as $genre)
                            <option value="{{ $genre->id }}" @selected(in_array($genre->id, $selectedGenreIds))>{{ $genre->name }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-mist/60">Hold Command on Mac or Ctrl on Windows to choose more than one genre.</p>
                </div>
                <div class="md:col-span-2">
                    <x-ui.textarea name="directors" label="Directors" placeholder="Ava Chen&#10;Marcus Lee">{{ $directorNames }}</x-ui.textarea>
                    <p class="mt-2 text-xs text-mist/60">Add one director per line.</p>
                </div>
                <div class="md:col-span-2">
                    <x-ui.textarea name="cast_members" label="Cast members" placeholder="John Smith&#10;Jane Doe">{{ $castNames }}</x-ui.textarea>
                    <p class="mt-2 text-xs text-mist/60">Add one cast member per line.</p>
                </div>
                <div class="flex flex-col gap-2 md:col-span-2">
                    <label for="thumbnail" class="text-sm font-medium text-white">Replace thumbnail</label>
                    <input id="thumbnail" name="thumbnail" type="file" accept="image/jpeg,image/png,image/webp" class="w-full rounded-md border border-dashed border-line bg-ink px-3 py-2 text-sm text-mist file:mr-4 file:rounded-md file:border-0 file:bg-gold file:px-3 file:py-1.5 file:text-sm file:font-semibold file:text-ink hover:file:bg-gold-deep focus:border-gold focus:outline-none">
                    <p class="text-xs text-mist/60">Leave empty to keep the current thumbnail.</p>
                </div>
                <div class="md:col-span-2">
                    <x-ui.textarea name="body" label="Description">{{ old('body', $movie->body) }}</x-ui.textarea>
                </div>
            </div>

            <div class="mt-7 flex flex-wrap gap-3">
                <x-ui.button type="submit">Save changes</x-ui.button>
                <a href="{{ route('admin.movies.index') }}" class="inline-flex items-center justify-center rounded-lg border border-line px-4 py-2 text-sm font-medium text-mist transition hover:border-gold hover:text-white">Cancel</a>
            </div>
        </form>
    </section>
</x-admin.layout>
