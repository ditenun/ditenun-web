<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class Faq extends Model{
	protected $table = 'faq';

  	protected $fillable = [
  		'judul', 
  		'deskripsi',
  	];
}
