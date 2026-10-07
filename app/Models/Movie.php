<?php

namespace App\Models;

use Database\Factories\MovieFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Movie extends Model
{
    /** @use HasFactory<MovieFactory> */
    use HasFactory;

    public function scopeFilter($query, array $filter)
    {
        $query->when($filter['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('genre', 'like', "%{$search}%")
                    ->orWhere('director', 'like', "%{$search}%");
            });
        });

        $query->when($filter['genre'] ?? null, function ($query, $genre) {
            $query->where('genre', 'like', "%{$genre}%");
        });

        $query->when($filter['director'] ?? null, function ($query, $director) {
            $query->where('director', 'like', "%{$director}%");
        });
    }

    public function people(): BelongsToMany
    {
        return $this->belongsToMany(Person::class);
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'rating' => 'decimal:1',
        ];
    }
}
