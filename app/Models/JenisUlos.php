<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisUlos extends Model {

    protected $table = 'jenis ulos';

    protected $dates = [];

    public static $rules = [
      "namaUlos" => "required",
    ];

    // Relationships
    // public function warnaHasKristik(){
    //   return $this->hasMany("App\Models\ResultKristik", 'warna', 'id');
    // }

}
