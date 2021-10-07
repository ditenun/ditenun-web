<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransparantImageKristik extends Model {
    protected $table = 'transparant_kristik';
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
