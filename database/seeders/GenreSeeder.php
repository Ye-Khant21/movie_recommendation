<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ([
            'Action',
            'Adventure',
            'Animation',
            'Comedy',
            'Documentary',
            'Drama',
            'Horror',
            'Romance',
            'Sci-Fi',
            'Thriller',
        ] as $name) {
            Genre::query()->firstOrCreate(
                ['name' => $name],
                ['slug' => Str::slug($name)],
            );
        }
    }
}
