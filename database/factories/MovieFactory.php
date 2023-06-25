<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
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
		$fakerKa = \Faker\Factory::create('ka_GE');
		if (!Storage::disk('public')->exists('movies')) {
			Storage::disk('public')->makeDirectory('movies');
		}

		return [
			'name'        => [
				'en' => fake()->name(),
				'ka' => $fakerKa->realText(15),
			],
			'director'    => [
				'en' => fake()->name(),
				'ka' => $fakerKa->realText(25),
			],
			'description' => [
				'en' => fake()->name(),
				'ka' => $fakerKa->realText(40),
			],
			'thumbnail'   => $this->generateThumbnail(),
			'user_id'     => User::factory(),
		];
	}

	private function generateThumbnail(): string
	{
		$thumbnail = $this->faker->image('public/storage/movies', 640, 480, null, false);

		return '/storage/movies/' . pathinfo($thumbnail, PATHINFO_BASENAME);
	}
}
