<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OriginalImage extends Model {

    protected $table = 'original_image';

    protected $dates = [];

    protected $fillable = [
        'id',
        'name_image',
        'id_jenis_ulos',
        'path',
        'description'
    ];

    public static $rules = [
      "id" => 'required',
      "name_image" => "required",
      "id_jenis_ulos" => "required",
      "path"=> "required",
      "description"=> "required",
    ];

    // Relationships
    public function getUrlAttribute()
    {
        return url($this->path);
    }

}
