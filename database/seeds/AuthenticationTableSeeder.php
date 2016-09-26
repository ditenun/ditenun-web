<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Authentication;

class AuthenticationTableSeeder extends Seeder
{
  public function run(){
    Authentication::create([
        'user_group' => '5',
        'user_id' => '99',
        'access_token' => Hash::make('5&99')
    ]);

    Authentication::create([
        'user_group' => '1',
        'user_id' => '88',
        'access_token' => Hash::make('1&88')
    ]);
  }
}
