<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMotifJenisTenunsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('motif_jenis_tenuns', function(Blueprint $table) {
          $table->engine = 'InnoDB';

        	$table->increments('id_motif');
        	$table->integer('id_jenis_tenun')->unsigned();
        	$table->string('nama_motif_jenis_tenun', 75);
        	$table->integer('rating');

          $table->foreign('id_jenis_tenun')->references('id_jenis_tenun')->on('jenis_tenuns');

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
        Schema::drop('motif_jenis_tenuns');
    }
}
