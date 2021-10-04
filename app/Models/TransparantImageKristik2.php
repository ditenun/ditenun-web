<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransparantImageKristik2 extends Model {
    protected $table = 'result_generate_kristik';
    protected $fillable = ['id_original_image','name_image', 'path', 'benang', 'warna', 'motif'];


    protected $appends = ['url'];

    public static $rules = [
        // Validation rules
        "id" => 'required',
        "id_original_image" => 'required',
        "name_image" => "required",
        "path" => "required",
        "benang" => "required",
        "warna" =>"required",
        "motif" => "required"

    ];

    public function getUrlAttribute()
    {
        return url($this->path);
    }


    // Relationships

}
