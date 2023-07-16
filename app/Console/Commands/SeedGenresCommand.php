<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SeedGenresCommand extends Command
{
	protected $signature = 'seed:genres';

	protected $description = 'Seed genres table with predefined genres';

	public static $genres;

	/**
	 * Execute the console command.
	 */
	public function handle()
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
				'created_at' => now(),
				'updated_at' => now(),
			]);
		}

		$this->info('Genres seeded successfully!');

		self::$genres = DB::table('genres')->get();
	}
}
