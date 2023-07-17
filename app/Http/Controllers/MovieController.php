<?php

namespace App\Http\Controllers;

use App\Http\Requests\Movie\StoreMovieRequest;
use App\Http\Requests\Movie\UpdateMovieRequest;
use App\Http\Resources\Movie\MoviesResource;
use App\Http\Resources\Movie\MovieEditResource;
use App\Http\Resources\Movie\MovieResource;
use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
	public function getMovies(): JsonResponse
	{
		return response()->json(MoviesResource::collection(auth()->user()->movies->sortByDesc('created_at')));
	}

	public function getMovie(Movie $movie): JsonResponse
	{
		return response()->json(new MovieResource($movie));
	}

	public function StoreMovie(StoreMovieRequest $request): JsonResponse
	{
		$thumbnailPath = $request->thumbnail->store('movies', 'public');

		$movie = Movie::create([
			'user_id' => auth()->id(),
			'name'    => [
				'en' => $request->name_en,
				'ka' => $request->name_ka,
			],
			'director' => [
				'en' => $request->director_en,
				'ka' => $request->director_ka,
			],
			'description' => [
				'en' => $request->description_en,
				'ka' => $request->description_ka,
			],
			'release_year' => $request->release_year,
			'thumbnail'    => '/storage/' . $thumbnailPath,
		]);

		$genreIds = explode(',', $request->genre_ids);
		$movie->genres()->attach($genreIds);

		return response()->json(new MoviesResource($movie));
	}

	public function editMovie(Movie $movie): JsonResponse
	{
		return response()->json(new MovieEditResource($movie));
	}

	public function updateMovie(UpdateMovieRequest $request, Movie $movie): JsonResponse
	{
		$movie->update([
			'name'    => [
				'en' => $request->name_en,
				'ka' => $request->name_ka,
			],
			'director' => [
				'en' => $request->director_en,
				'ka' => $request->director_ka,
			],
			'description' => [
				'en' => $request->description_en,
				'ka' => $request->description_ka,
			],
			'release_year' => $request->release_year,
		]);
		if ($request->hasFile('thumbnail')) {
			Storage::disk('public')->delete($movie->thumbnail);
			$thumbnailPath = $request->thumbnail->store('movies', 'public');
			$movie->update([
				'thumbnail' => '/storage/' . $thumbnailPath,
			]);
		}
		$genreIds = explode(',', request()->genre_ids);
		$movie->genres()->sync($genreIds);

		return response()->json(new MoviesResource($movie));
	}

	public function deleteMovie(Movie $movie): JsonResponse
	{
		$movie->delete();

		return response()->json(['message' => 'Movie deleted successfully']);
	}
}
