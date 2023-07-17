<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\Genre\GenreCollection;

class GenreController extends Controller
{
	public function index(): JsonResponse
	{
		return response()->json(new GenreCollection(Genre::all()));
	}
}
