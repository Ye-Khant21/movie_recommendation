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
                    ->orWhere('director', 'like', "%{$search}%")
                    ->orWhereHas('people', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%");
                    });
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

    public function actors(): BelongsToMany
    {
        return $this->belongsToMany(Person::class)->where('role', 'actor');
    }

    public function actresses(): BelongsToMany
    {
        return $this->belongsToMany(Person::class)->where('role', 'actress');
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
