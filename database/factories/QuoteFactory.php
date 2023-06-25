<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Movie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class QuoteFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		$fakerKa = \Faker\Factory::create('ka_GE');
		if (!Storage::disk('public')->exists('quotes')) {
			Storage::disk('public')->makeDirectory('quotes');
		}
		return [
			'content'    => [
				'en' => fake()->realText(40),
				'ka' => $fakerKa->realText(40),
			],
			'thumbnail'  => $this->generateThumbnail(),
			'movie_id'   => Movie::factory(),
			'user_id'    => User::factory(),
		];
	}

	private function generateThumbnail(): string
	{
		$thumbnail = $this->faker->image('public/storage/quotes', 640, 480, null, false);

		return '/storage/quotes/' . pathinfo($thumbnail, PATHINFO_BASENAME);
	}
}
