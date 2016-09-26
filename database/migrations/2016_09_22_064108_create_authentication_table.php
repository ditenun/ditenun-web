<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthenticationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('authentications', function(Blueprint $table) {
        $table->engine = 'InnoDB';

        $table->increments('id_auth');
        $table->integer('user_group')->unsigned();
        $table->integer('user_id')->unsigned();
        $table->string('access_token', 75);

        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
