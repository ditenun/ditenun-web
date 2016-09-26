<?php

use App\Models\MotifJenisTenun;
use Illuminate\Database\Seeder;

class MotifTenunTableSeeder extends Seeder {
  public function run(){
    MotifJenisTenun::create([
      'id_jenis_tenun' => '2',
      'nama_motif_jenis_tenun' => 'potonganCantikNanMenawanA',
      'rating' => '3'
    ]);

    MotifJenisTenun::create([
      'id_jenis_tenun' => '2',
      'nama_motif_jenis_tenun' => 'potonganCantikNanMenawanB',
      'rating' => '3'
    ]);

    MotifJenisTenun::create([
      'id_jenis_tenun' => '2',
      'nama_motif_jenis_tenun' => 'potonganCantikNanMenawanC',
      'rating' => '4'
    ]);

    MotifJenisTenun::create([
      'id_jenis_tenun' => '4',
      'nama_motif_jenis_tenun' => 'potonganCantikNanMenawanD',
      'rating' => '2'
    ]);

    MotifJenisTenun::create([
      'id_jenis_tenun' => '3',
      'nama_motif_jenis_tenun' => 'potonganCantikNanMenawanE',
      'rating' => '1'
    ]);

    MotifJenisTenun::create([
      'id_jenis_tenun' => '2',
      'nama_motif_jenis_tenun' => 'potonganCantikNanMenawan',
      'rating' => '3'
    ]);
  }
}
