<?php

use App\Models\Tenun;
use Illuminate\Database\Seeder;

class TenunTableSeeder extends Seeder{
  public function run(){
    Tenun::create([
      'nama_tenun' => 'Bali',
      'asal_tenun' => 'Bali',
      'deskripsi_tenun' => "Dari Bali",
      'sejarah_tenun' => "its been a long timee..."
    ]);

    Tenun::create([
      'nama_tenun' => 'Sumatera',
      'asal_tenun' => 'Balige',
      'deskripsi_tenun' => "Dari Baliz",
      'sejarah_tenun' => "its been a long timee..."
    ]);

    Tenun::create([
      'nama_tenun' => 'Balian',
      'asal_tenun' => 'Balia',
      'deskripsi_tenun' => "Dari xBali",
      'sejarah_tenun' => "its been a long timee..."
    ]);

    Tenun::create([
      'nama_tenun' => 'Bali2',
      'asal_tenun' => 'Bali1',
      'deskripsi_tenun' => "Dari Bali",
      'sejarah_tenun' => "its been a long timee..."
    ]);
  }
}
