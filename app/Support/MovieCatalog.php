<?php

namespace App\Support;

class MovieCatalog
{
    /**
     * @return list<array<string, mixed>>
     */
    public function all(): array
    {
        return array_values(config('movies.catalog'));
    }

    /**
     * @return array<string, mixed>|null
     */
    public function find(int $id): ?array
    {
        return config('movies.catalog')[$id] ?? null;
    }

    /**
     * @return list<int>
     */
    public function likedIds(): array
    {
        return array_map(intval(...), session('liked_movies', []));
    }

    public function isLiked(int $id): bool
    {
        return in_array($id, $this->likedIds(), true);
    }

    public function toggleLike(int $id): void
    {
        abort_unless($this->find($id) !== null, 404);

        $ids = collect($this->likedIds());

        $ids = $ids->contains($id)
            ? $ids->reject(fn (int $likedId): bool => $likedId === $id)->values()
            : $ids->push($id);

        session(['liked_movies' => $ids->all()]);
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function favorites(): array
    {
        return collect($this->likedIds())
            ->map(fn (int $id): ?array => $this->find($id))
            ->filter()
            ->values()
            ->all();
    }
}
