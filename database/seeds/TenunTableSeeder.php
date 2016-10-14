<?php

use App\Models\Tenun;
use Illuminate\Database\Seeder;

class TenunTableSeeder extends Seeder{
  public function run(){

    for($i = 0 ; $i < 5 ; $i++){
      Tenun::create([
        'nama_tenun' => 'Jakarta Bali',
        'deskripsi_tenun' => "Dari Jakarta Bali",
        'sejarah_tenun' => "its been a long timee...",
        'kegunaan_tenun' => 'Syukuran',
        'warna_dominan' => '#FFF000',
        'asal_tenun' => 'Bali',
        'img_src' => 'public/img_src/flores_b.jpg'
      ]);

      Tenun::create([
        'nama_tenun' => 'Medan Balige',
        'deskripsi_tenun' => "Dari Balige",
        'sejarah_tenun' => "its been a long timee lae...",
        'kegunaan_tenun' => 'Kematian',
        'warna_dominan' => '#FFFF00',
        'asal_tenun' => 'Sangkarnighuya',
        'img_src' => 'public/img_src/flores_a.jpg'
      ]);


      Tenun::create([
        'nama_tenun' => 'Entahlahhh Tenun',
        'deskripsi_tenun' => "Dari Sumatra",
        'sejarah_tenun' => "its been a long timasddee...",
        'kegunaan_tenun' => 'Pernikahan',
        'warna_dominan' => '#FFF000',
        'asal_tenun' => 'Bali',
        'img_src' => 'public/img_src/flores_c.jpg'
      ]);


      Tenun::create([
        'nama_tenun' => 'IDK dude',
        'deskripsi_tenun' => "yiipppeeee Bali",
        'sejarah_tenun' => "its been a long timee...",
        'kegunaan_tenun' => 'Syukuran',
        'warna_dominan' => '#FFF500',
        'asal_tenun' => 'Bali',
        'img_src' => 'public/img_src/flores_b.jpg'
      ]);
    }
  }
}
