<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Like;
use App\Models\User;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\Quote;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 */
	public function run(): void
	{
		$users = User::factory(3)->create();

		foreach ($users as $user) {
			$movies = Movie::factory(5)->create(['user_id' => $user->id]);

			foreach ($movies as $movie) {
				Quote::factory(5)->create([
					'user_id'  => $user->id,
					'movie_id' => $movie->id,
				]);

				$genres = Genre::factory(3)->create();

				$movie->genres()->attach($genres->pluck('id'));

				$likes = Like::factory(10)->create([
					'user_id'  => $user->id,
					'quote_id' => $movie->quotes->pluck('id')->random(),
				]);

				$comments = Comment::factory(10)->create([
					'user_id'  => $user->id,
					'quote_id' => $movie->quotes->pluck('id')->random(),
				]);
			}
		}
	}
}
