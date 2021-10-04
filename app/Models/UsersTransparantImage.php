<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersTransparantImage extends Model {

    protected $table = 'user_transparant_kristik';
    protected $fillable = ['name','id_image','file_path'];


    protected $appends = ['url'];

    public static $rules = [
        // Validation rules
        "id" => 'required',
        "name" => "required",
        "id_image" => "required",
        "file_path" => "required",
    ];

    public function getUrlAttribute()
    {
        return url($this->file_path);
    }


    // Relationships


}
