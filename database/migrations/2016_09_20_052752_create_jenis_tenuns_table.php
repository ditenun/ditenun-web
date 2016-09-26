<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJenisTenunsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jenis_tenuns', function(Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id_jenis_tenun');
            $table->integer('id_tenun')->unsigned();
            $table->string('nama_jenis_tenun', 75)->nullable()->default(NULL);
            $table->string('warna_dominan', 15)->nullable()->default(NULL);
            $table->string('deskripsi_jenis_tenun', 200)->nullable()->default(NULL);
            $table->string('kegunaan_tenun', 100)->nullable()->default(NULL);
            $table->string('asal_tenun', 100)->nullable()->default(NULL);

            $table->foreign('id_tenun')->references('id_tenun')->on('tenuns');

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
        Schema::drop('jenis_tenuns');
    }
}
