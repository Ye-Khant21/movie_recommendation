<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Movie;
use App\Models\Person;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AnimeSeriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->series() as $series) {
            $movie = Movie::query()->updateOrCreate(
                ['title' => $series['title']],
                [
                    'genre' => implode(', ', $series['genres']),
                    'director' => $series['directors'][0],
                    'rating' => $series['rating'],
                    'poster' => $series['poster'],
                    'body' => $series['body'],
                ],
            );

            $movie->genres()->sync(collect($series['genres'])
                ->map(fn (string $name): int => Genre::query()->firstOrCreate(
                    ['name' => $name],
                    ['slug' => Str::slug($name)],
                )->id)
                ->all());

            $credits = [];

            foreach ($series['directors'] as $name) {
                $credits[Person::query()->firstOrCreate(['name' => $name], ['role' => 'person'])->id] = ['role' => 'director'];
            }

            foreach ($series['cast'] as $name) {
                $credits[Person::query()->firstOrCreate(['name' => $name], ['role' => 'person'])->id] = ['role' => 'cast'];
            }

            $movie->people()->sync($credits);
        }
    }

    /**
     * @return list<array{title: string, genres: list<string>, directors: list<string>, cast: list<string>, rating: float, poster: string, body: string}>
     */
    private function series(): array
    {
        return [
            ['title' => 'Attack on Titan', 'genres' => ['Action', 'Drama', 'Fantasy'], 'directors' => ['Tetsuro Araki'], 'cast' => ['Yuki Kaji', 'Yui Ishikawa', 'Marina Inoue'], 'rating' => 9.1, 'poster' => 'https://cdn.myanimelist.net/images/anime/10/47347l.jpg', 'body' => 'Humanity survives behind towering walls while Eren Yeager and his friends fight the Titans beyond them.'],
            ['title' => 'Fullmetal Alchemist: Brotherhood', 'genres' => ['Action', 'Adventure', 'Fantasy'], 'directors' => ['Yasuhiro Irie'], 'cast' => ['Romi Park', 'Rie Kugimiya', 'Shinichiro Miki'], 'rating' => 9.1, 'poster' => 'https://cdn.myanimelist.net/images/anime/1208/94745l.jpg', 'body' => 'Two brothers search for the Philosopher’s Stone after a failed alchemy experiment costs them their bodies.'],
            ['title' => 'Death Note', 'genres' => ['Mystery', 'Supernatural', 'Thriller'], 'directors' => ['Tetsuro Araki'], 'cast' => ['Mamoru Miyano', 'Kappei Yamaguchi', 'Shido Nakamura'], 'rating' => 8.9, 'poster' => 'https://cdn.myanimelist.net/images/anime/9/9453l.jpg', 'body' => 'A brilliant student finds a notebook that can kill anyone whose name is written inside it.'],
            ['title' => 'Demon Slayer: Kimetsu no Yaiba', 'genres' => ['Action', 'Adventure', 'Fantasy'], 'directors' => ['Haruo Sotozaki'], 'cast' => ['Natsuki Hanae', 'Akari Kito', 'Hiro Shimono'], 'rating' => 8.7, 'poster' => 'https://cdn.myanimelist.net/images/anime/1286/99889l.jpg', 'body' => 'Tanjiro becomes a demon slayer after his family is attacked and his sister is transformed into a demon.'],
            ['title' => 'Jujutsu Kaisen', 'genres' => ['Action', 'Fantasy', 'Supernatural'], 'directors' => ['Sunghoo Park'], 'cast' => ['Junya Enoki', 'Yuichi Nakamura', 'Asami Seto'], 'rating' => 8.6, 'poster' => 'https://cdn.myanimelist.net/images/anime/1171/109222l.jpg', 'body' => 'Yuji Itadori joins sorcerers who battle cursed spirits after swallowing a powerful cursed object.'],
            ['title' => 'Spy x Family', 'genres' => ['Action', 'Comedy', 'Drama'], 'directors' => ['Kazuhiro Furuhashi'], 'cast' => ['Takuya Eguchi', 'Saori Hayami', 'Atsumi Tanezaki'], 'rating' => 8.5, 'poster' => 'https://cdn.myanimelist.net/images/anime/1441/122795l.jpg', 'body' => 'A spy, an assassin, and a telepathic child form a secret family for a high-stakes mission.'],
            ['title' => 'Frieren: Beyond Journey’s End', 'genres' => ['Adventure', 'Drama', 'Fantasy'], 'directors' => ['Keiichiro Saito'], 'cast' => ['Atsumi Tanezaki', 'Kana Ichinose', 'Chiaki Kobayashi'], 'rating' => 9.0, 'poster' => 'https://cdn.myanimelist.net/images/anime/1015/138006l.jpg', 'body' => 'An elven mage begins a new journey after realizing how little she understood her human companions.'],
            ['title' => 'Naruto: Shippuden', 'genres' => ['Action', 'Adventure', 'Fantasy'], 'directors' => ['Hayato Date'], 'cast' => ['Junko Takeuchi', 'Noriaki Sugiyama', 'Chie Nakamura'], 'rating' => 8.7, 'poster' => 'https://cdn.myanimelist.net/images/anime/1565/111305l.jpg', 'body' => 'Naruto returns to his village older and stronger, determined to protect his friends and become Hokage.'],
            ['title' => 'One Piece', 'genres' => ['Action', 'Adventure', 'Comedy'], 'directors' => ['Konosuke Uda'], 'cast' => ['Mayumi Tanaka', 'Kazuya Nakai', 'Akemi Okamura'], 'rating' => 8.9, 'poster' => 'https://cdn.myanimelist.net/images/anime/6/73245l.jpg', 'body' => 'Monkey D. Luffy and the Straw Hat Pirates sail the Grand Line in search of the legendary One Piece.'],
            ['title' => 'Cowboy Bebop', 'genres' => ['Action', 'Adventure', 'Drama'], 'directors' => ['Shinichiro Watanabe'], 'cast' => ['Koichi Yamadera', 'Unsho Ishizuka', 'Megumi Hayashibara'], 'rating' => 8.8, 'poster' => 'https://cdn.myanimelist.net/images/anime/4/19644l.jpg', 'body' => 'A group of bounty hunters travel through space while confronting the pasts they cannot escape.'],
        ];
    }
}
