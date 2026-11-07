<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('genre_movie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('genre_id')->constrained()->cascadeOnDelete();
            $table->foreignId('movie_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['genre_id', 'movie_id']);
        });

        DB::table('movies')
            ->select(['id', 'genre'])
            ->whereNotNull('genre')
            ->orderBy('id')
            ->each(function (object $movie): void {
                foreach (array_filter(array_map('trim', explode(',', $movie->genre))) as $genreName) {
                    $genre = DB::table('genres')->where('name', $genreName)->first();

                    if ($genre === null) {
                        $genreId = DB::table('genres')->insertGetId([
                            'name' => $genreName,
                            'slug' => Str::slug($genreName),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    } else {
                        $genreId = $genre->id;
                    }

                    DB::table('genre_movie')->insertOrIgnore([
                        'genre_id' => $genreId,
                        'movie_id' => $movie->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('genre_movie');
    }
};
