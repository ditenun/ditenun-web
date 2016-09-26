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
        $this->call('AuthenticationTableSeeder');

        //comment after used
        /*
        $this->call('TenunTableSeeder');
        $this->call('JenisTenunTableSeeder');
        $this->call('MotifTenunTableSeeder');
        */
    }
}
