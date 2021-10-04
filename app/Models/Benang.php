<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Benang extends Model {

    protected $table = 'benang';

    protected $dates = [];

    public static $rules = [
      "type_benang" => "required",
    ];

    // Relationships
    public function benangHasKristik(){
      return $this->hasMany("App\Models\ResultKristik", 'benang', 'id');
    }

}
