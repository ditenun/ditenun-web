<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableParameterAlgoritma extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('algoritma_parameters', function (Blueprint $table) {
          $table->engine = 'InnoDB';

          $table->increments('id');
          $table->integer('id_algoritma')->unsigned();
          $table->foreign('id_algoritma')->references('id')->on('algoritmas');
          $table->enum('type_algoritma',['Float', 'String', 'Boolean']);
          $table->string('min_val', 75)->nullable()->default(NULL);
          $table->string('max_val', 75)->nullable()->default(NULL);

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
