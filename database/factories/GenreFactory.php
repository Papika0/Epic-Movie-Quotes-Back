<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Genre>
 */
class GenreFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		$genres = [
			'Action'            => ['en' => 'Action', 'ka' => 'მოქმედება'],
			'Adventure'         => ['en' => 'Adventure', 'ka' => 'სათავგადასავლო'],
			'Animation'         => ['en' => 'Animation', 'ka' => 'ანიმაცია'],
			'Biography'         => ['en' => 'Biography', 'ka' => 'ბიოგრაფია'],
			'Comedy'            => ['en' => 'Comedy', 'ka' => 'კომედია'],
			'Crime'             => ['en' => 'Crime', 'ka' => 'კრიმინალი'],
			'Cult Movie'        => ['en' => 'Cult Movie', 'ka' => 'კულტურული ფილმი'],
			'Disney'            => ['en' => 'Disney', 'ka' => 'დისნეი'],
			'Documentary'       => ['en' => 'Documentary', 'ka' => 'დოკუმენტალური'],
			'Drama'             => ['en' => 'Drama', 'ka' => 'დრამა'],
			'Erotic'            => ['en' => 'Erotic', 'ka' => 'ეროტიკული'],
			'Family'            => ['en' => 'Family', 'ka' => 'საოჯახო'],
			'Fantasy'           => ['en' => 'Fantasy', 'ka' => 'ფანტასტიკა'],
			'Film-Noir'         => ['en' => 'Film-Noir', 'ka' => 'ფილმ-ნოირი'],
			'History'           => ['en' => 'History', 'ka' => 'ისტორია'],
			'Horror'            => ['en' => 'Horror', 'ka' => 'საშინელება'],
			'Military'          => ['en' => 'Military', 'ka' => 'სამხედრო'],
			'Music'             => ['en' => 'Music', 'ka' => 'მუსიკა'],
			'Musical'           => ['en' => 'Musical', 'ka' => 'მუსიკალური'],
			'Mystery'           => ['en' => 'Mystery', 'ka' => 'მისტიკა'],
			'Nature'            => ['en' => 'Nature', 'ka' => 'ბუნება'],
			'Period'            => ['en' => 'Period', 'ka' => 'პერიოდული'],
			'Pixar'             => ['en' => 'Pixar', 'ka' => 'პიქსარი'],
			'Romance'           => ['en' => 'Romance', 'ka' => 'რომანი'],
			'Sci-Fi'            => ['en' => 'Sci-Fi', 'ka' => 'საიდუმლო'],
			'Short'             => ['en' => 'Short', 'ka' => 'მოკლე'],
			'Spy'               => ['en' => 'Spy', 'ka' => 'შპიონი'],
			'Super Hero'        => ['en' => 'Super Hero', 'ka' => 'სუპერ გმირი'],
			'Thriller'          => ['en' => 'Thriller', 'ka' => 'თრილერი'],
			'War'               => ['en' => 'War', 'ka' => 'ომი'],
			'Western'           => ['en' => 'Western', 'ka' => 'ვესტერნი'],
		];

		foreach ($genres as $name => $translations) {
			DB::table('genres')->insert([
				'name'       => json_encode($translations),
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
			]);
		}

		return [
			'name'       => json_encode($genres[array_rand($genres)]),
			'created_at' => Carbon::now(),
			'updated_at' => Carbon::now(),
		];
	}
}
