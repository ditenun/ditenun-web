<?php

use App\Models\JenisTenun;
use Illuminate\Database\Seeder;

class JenisTenunTableSeeder extends Seeder{
  public function run(){
    JenisTenun::create([
        'id_tenun' => '2',
        'nama_jenis_tenun' => 'Bali_a',
        'warna_dominan' => 'FF0000',
        'deskripsi_jenis_tenun' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore",
        'kegunaan_tenun' => 'Busana',
        'asal_tenun' => 'Bali'
    ]);

    JenisTenun::create([
        'id_tenun' => '2',
        'nama_jenis_tenun' => 'Bali_a',
        'warna_dominan' => 'FF0000',
        'deskripsi_jenis_tenun' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore",
        'kegunaan_tenun' => 'Busana',
        'asal_tenun' => 'Bali'
    ]);

    JenisTenun::create([
        'id_tenun' => '4',
        'nama_jenis_tenun' => 'Bali_b',
        'warna_dominan' => 'DF0000',
        'deskripsi_jenis_tenun' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore",
        'kegunaan_tenun' => 'IDK',
        'asal_tenun' => 'Bali'
    ]);

    JenisTenun::create([
        'id_tenun' => '2',
        'nama_jenis_tenun' => 'Bali_C',
        'warna_dominan' => 'FF000F',
        'deskripsi_jenis_tenun' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore",
        'kegunaan_tenun' => 'BusanI',
        'asal_tenun' => 'BaliGE'
    ]);

  }
}
