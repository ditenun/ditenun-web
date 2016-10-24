<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Algoritma;

class AlgoritmaTableSeeder extends Seeder
{
  public function run(){
    Algoritma::create([
        'nama_algoritma' => 'Test',
        'description' => 'Test'
    ]);

    Algoritma::create([
        'nama_algoritma' => 'Test2',
        'description' => 'Soemthing'
    ]);
  }
}
