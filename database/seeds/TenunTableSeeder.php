<?php

use App\Models\Tenun;
use Illuminate\Database\Seeder;

class TenunTableSeeder extends Seeder{
  public function run(){
    Tenun::create([
      'nama_tenun' => 'IDK Bali',
      'deskripsi_tenun' => "Dari Bali",
      'sejarah_tenun' => "its been a long timee...",
      'kegunaan_tenun' => 'Syukuran',
      'warna_dominan' => '#FFF000',
      'asal_tenun' => 'Bali',
    ]);

    Tenun::create([
      'nama_tenun' => 'Ulos Balige',
      'deskripsi_tenun' => "Dari Balige",
      'sejarah_tenun' => "its been a long timee lae...",
      'kegunaan_tenun' => 'Kematian',
      'warna_dominan' => '#FFFF00',
      'asal_tenun' => 'Sangkarnighuya',
    ]);


    Tenun::create([
      'nama_tenun' => 'Sumatra Tenun',
      'deskripsi_tenun' => "Dari Sumatra",
      'sejarah_tenun' => "its been a long timasddee...",
      'kegunaan_tenun' => 'Pernikahan',
      'warna_dominan' => '#FFF000',
      'asal_tenun' => 'Bali',
    ]);


    Tenun::create([
      'nama_tenun' => 'Bali',
      'deskripsi_tenun' => "Dari Bali",
      'sejarah_tenun' => "its been a long timee...",
      'kegunaan_tenun' => 'Syukuran',
      'warna_dominan' => '#FFF500',
      'asal_tenun' => 'Bali',
    ]);

  }
}
