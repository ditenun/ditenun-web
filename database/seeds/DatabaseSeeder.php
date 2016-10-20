<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      //comment after used


      //  $this->call('AuthenticationTableSeeder');
      //  $this->call('TenunTableSeeder');
        $this->call('MotifTenunTableSeeder');
    }
}
