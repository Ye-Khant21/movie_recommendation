<?php

namespace Database\Factories;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'genre' => $this->faker->word(),
            'director' => $this->faker->name(),
            'rating' => $this->faker->randomFloat(1, 0, 10),
            'poster' => $this->faker->imageUrl(),
        ];
    }
}
