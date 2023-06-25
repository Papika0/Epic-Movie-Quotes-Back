<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class Quote extends Model
{
	use HasFactory , HasTranslations;

	public $translatable = ['content'];

	protected $guarded = ['id'];

	public function movie()
	{
		return $this->belongsTo(Movie::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function likes()
	{
		return $this->belongsToMany(User::class, 'likes');
	}

	public function comments()
	{
		return $this->hasMany(Comment::class);
	}
}
