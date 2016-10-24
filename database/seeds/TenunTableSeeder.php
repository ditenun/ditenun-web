<?php

use App\Models\Tenun;
use Illuminate\Database\Seeder;

class TenunTableSeeder extends Seeder{
  public function run(){

      Tenun::create([
        'nama_tenun' => 'Tenun Papua',
        'deskripsi_tenun' => "Dari Papua",
        'sejarah_tenun' => "its been a long timee...",
        'kegunaan_tenun' => 'Adat - Pernikahan',
        'warna_dominan' => '#FFF000',
        'asal_tenun' => 'Papua',
        'img_src' => 'public/img_src/flores_b.jpg'
      ]);

      Tenun::create([
        'nama_tenun' => 'IDK dude',
        'deskripsi_tenun' => "yiipppeeee asdd",
        'sejarah_tenun' => "its been a long timee...",
        'kegunaan_tenun' => 'Adat - Lainnya',
        'warna_dominan' => '#FFF500',
        'asal_tenun' => 'Daerah - Lainnya',
        'img_src' => 'public/img_src/flores_b.jpg'
      ]);

      Tenun::create([
        'nama_tenun' => 'Dari Sulawesi',
        'deskripsi_tenun' => "yiipppeeee asdd",
        'sejarah_tenun' => "its been a long timee...",
        'kegunaan_tenun' => 'Adat - Penghargaan',
        'warna_dominan' => '#FFF500',
        'asal_tenun' => 'Sulawesi',
        'img_src' => 'public/img_src/flores_b.jpg'
      ]);

      Tenun::create([
        'nama_tenun' => 'Dari Kalimantan',
        'deskripsi_tenun' => "yiipppeeee asdd",
        'sejarah_tenun' => "its been a long timee...",
        'kegunaan_tenun' => 'Adat - Syukuran',
        'warna_dominan' => '#FFF500',
        'asal_tenun' => 'Kalimantan',
        'img_src' => 'public/img_src/flores_b.jpg'
      ]);
  }
}
