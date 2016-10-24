<?php

use App\Models\MotifTenun;
use Illuminate\Database\Seeder;

class MotifTenunTableSeeder extends Seeder {
  public function run(){
        MotifTenun::create([
          'id_tenun' => '5',
          'nama_motif' => 'motif_jogja_E1',
          'img_src' => 'public/img_src/motif_jogja_E1.jpg'
        ]);

        MotifTenun::create([
          'id_tenun' => '8',
          'nama_motif' => 'motif_jogja_E2',
          'img_src' => 'public/img_src/motif_jogja_E2.jpg'
        ]);
  }
}
