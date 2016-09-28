<?php

use App\Models\MotifTenun;
use Illuminate\Database\Seeder;

class MotifTenunTableSeeder extends Seeder {
  public function run(){
    MotifTenun::create([
      'id_tenun' => '2',
      'nama_motif' => 'potonganCantikNanMenawanA'
    ]);

    MotifTenun::create([
      'id_tenun' => '2',
      'nama_motif' => 'potonganCantikNanMenawanB',
    ]);

    MotifTenun::create([
      'id_tenun' => '3',
      'nama_motif' => 'potonganCantikNanMenawanC',
    ]);

  }
}
