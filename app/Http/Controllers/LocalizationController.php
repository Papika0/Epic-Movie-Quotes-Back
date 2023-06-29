<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;

class LocalizationController extends Controller
{
	public function setLanguage(string $locale)
	{
		App::setLocale($locale);
		session()->put('locale', $locale);
		return response()->json([
			'status' => true,
			'data'   => 'language changed',
			'locale' => App::getLocale(),
		], 200);
	}
}
