<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\Person;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Movie::factory()
            ->count(2)
            ->create()
            ->each(function (Movie $movie): void {
                $people = Person::factory()
                    ->count(4)
                    ->create();

                $movie->people()->attach($people->modelKeys());
            });
    }
}
