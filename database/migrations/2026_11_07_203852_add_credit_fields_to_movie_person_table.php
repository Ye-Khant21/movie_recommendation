<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('movie_person', function (Blueprint $table) {
            $table->string('role')->default('cast')->after('person_id');
            $table->string('character_name')->nullable()->after('role');
        });

        DB::table('movies')
            ->select(['id', 'director'])
            ->whereNotNull('director')
            ->orderBy('id')
            ->each(function (object $movie): void {
                foreach (array_filter(array_map('trim', explode(',', $movie->director))) as $directorName) {
                    $person = DB::table('people')->where('name', $directorName)->first();

                    if ($person === null) {
                        $personId = DB::table('people')->insertGetId([
                            'name' => $directorName,
                            'role' => 'person',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    } else {
                        $personId = $person->id;
                    }

                    if (! DB::table('movie_person')
                        ->where('movie_id', $movie->id)
                        ->where('person_id', $personId)
                        ->where('role', 'director')
                        ->exists()) {
                        DB::table('movie_person')->insert([
                            'movie_id' => $movie->id,
                            'person_id' => $personId,
                            'role' => 'director',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movie_person', function (Blueprint $table) {
            $table->dropColumn(['role', 'character_name']);
        });
    }
};
