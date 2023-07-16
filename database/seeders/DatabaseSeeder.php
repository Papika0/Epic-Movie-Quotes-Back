<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Movie;
use App\Models\Quote;
use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\SeedGenresCommand;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 */
	public function run(): void
	{
		$users = User::factory(3)->create();

		Artisan::call('seed:genres');

		$genres = SeedGenresCommand::$genres;

		$randomUsers = User::factory(25)->create();

		foreach ($users as $user) {
			$movies = Movie::factory(5)->create(['user_id' => $user->id]);

			foreach ($movies as $movie) {
				$quotes = Quote::factory(5)->create([
					'user_id'  => $user->id,
					'movie_id' => $movie->id,
				]);

				$quote = $quotes->random();

				$genre = $genres->random();
				$movie->genres()->attach($genre->id);

				foreach ($randomUsers as $randomUser) {
					$quote->likes()->attach($randomUser->id);

					$comments = Comment::factory(1)->create([
						'user_id'  => $randomUser->id,
						'quote_id' => $movie->quotes->pluck('id')->random(),
					]);
				}
			}
		}
	}
}
