<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAlgoritma extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('algoritmas', function (Blueprint $table) {
          $table->engine = 'InnoDB';

          $table->increments('id');

          $table->string('nama_algoritma', 75)->nullable()->default(NULL);
          $table->text('description')->nullable();

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
