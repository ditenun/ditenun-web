<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\AlgoritmaParameter;

class AlgoritmaParameterTableSeeder extends Seeder
{
  public function run(){
    AlgoritmaParameter::create([
        'id_algoritma' => 1,
        'type_algoritma' => 'String',
    ]);

    AlgoritmaParameter::create([
        'id_algoritma' => 1,
        'type_algoritma' => 'Float',
        'min_val' => '-50',
        'max_val' => '150'
    ]);
  }
}
