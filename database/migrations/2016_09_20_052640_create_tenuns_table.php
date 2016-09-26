<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTenunsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenuns', function(Blueprint $table) {
          $table->engine = 'InnoDB';

          $table->increments('id_tenun');
          $table->string('nama_tenun', 75)->nullable()->default(NULL);
          $table->string('asal_tenun', 75)->nullable()->default(NULL);
          $table->text('deskripsi_tenun')->nullable();
          $table->text('sejarah_tenun')->nullable();

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
        Schema::drop('tenuns');
    }
}
