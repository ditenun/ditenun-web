<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultGenerateMotif extends Model {

    protected $table = 'result_generate_motif';

    protected $fillable = [
        'id_transparant',
        'method',
        'path',
        'name_image'
    ];
    protected $dates = [];
    protected $appends = ['url'];

    public static $rules = [
      "method" => "required",
      "id_transparant" => "required",
      "path" => "required",
      "name_image" => "required"
    ];

    public function getUrlAttribute()
    {
        return url($this->path);
    }

    // //Relationships
    // public function idKristik()
    // {
    //   return $this->belongsTo("App\Models\ResultKristik", 'id_kristik');
    // }
    //
    // public function typeMethod()
    // {
    //   return $this->belongsTo("App\Models\TypeMethod", 'type_method');
    // }
}
