<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeGenerate extends Model {

    protected $table = 'type_generate';

    protected $dates = [];

    public static $rules = [
      "type_generate" => "required",
    ];

    //Relationships
    // public function methodHasMotif()
    // {
    //   return $this->hasMany("App\Models\ResultMotif", 'type_method', 'id');
    // }
}
