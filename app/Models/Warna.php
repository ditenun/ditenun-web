<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warna extends Model {

    protected $table = 'warna';

    protected $dates = [];

    public static $rules = [
      "type_color" => "required",
    ];

    // Relationships
    public function warnaHasKristik(){
      return $this->hasMany("App\Models\ResultKristik", 'warna', 'id');
    }

}
