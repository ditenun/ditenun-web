<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class FeedBack extends Model{
	protected $table = 'feedback';

  	protected $fillable = [
  		'subjek',
  		'deskripsi',
  		'rating',
			'user_id',
  	];
}
