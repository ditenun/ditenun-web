<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Motif extends Model {

    protected $table = 'type_motif';

    protected $dates = [];

    public static $rules = [
      "type_motif" => "required",
    ];

    // Relationships
    public function motifHasKristik(){
      return $this->hasMany("App\Models\ResultKristik", 'motif', 'id');
    }

}
