<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class KristikModel extends Model{
  protected $table = 'kristik_image';

  protected $fillable = [
    'name',
    'type',
    'file_path'
  ];

  protected $appends = ['url'];
  protected $dates = [];

  public static $rules = [
    "name" => "required",
    "type" => "required",
    "file_path" => "required"
  ];

  public function getUrlAttribute()
  {
    return url($this->file_path);
  }

}
