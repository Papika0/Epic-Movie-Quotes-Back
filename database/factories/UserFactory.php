<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		if (!Storage::disk('public')->exists('thumbnails')) {
			Storage::disk('public')->makeDirectory('thumbnails');
		}
		$username = fake()->unique()->userName();

		return [
			'username'          => $username,
			'email'             => fake()->unique()->safeEmail(),
			'email_verified_at' => now(),
			'password'          => 'password', // password
			'remember_token'    => Str::random(10),
			'thumbnail'         => $this->generateThumbnail($username),
		];
	}

	private function generateThumbnail($username): string
	{
		$firstName = strtoupper(substr($username, 0, 1));
		$thumbnail = $this->faker->image('public/storage/thumbnails', 180, 180, null, false, false, $firstName);

		return '/storage/thumbnails/' . pathinfo($thumbnail, PATHINFO_BASENAME);
	}

	/**
	 * Indicate that the model's email address should be unverified.
	 */
	public function unverified(): static
	{
		return $this->state(fn (array $attributes) => [
			'email_verified_at' => null,
		]);
	}
}
