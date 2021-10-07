<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class MotifTenun extends Model{
  protected $table = 'user_motif2';
  protected $fillable = ['name','file_path'];


  protected $appends = ['url'];

  public static $rules = [
      // Validation rules
      "id" => 'required',
      "name" => "required",
      "file_path" => "required",
  ];

  public function getUrlAttribute()
  {
      return url($this->file_path);
  }

  // Relationships
}
