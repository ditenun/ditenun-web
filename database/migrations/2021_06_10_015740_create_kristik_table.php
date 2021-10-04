<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKristikTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
 public function up()
 {
     Schema::create('kristik_image', function (Blueprint $table) {
         $table->increments('id');
         $table->string('name', 255);
         $table->string('type', 255);
         $table->string('file_path', 255);
         // $table->string('source_file', 255);
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
     Schema::dropIfExists('kristik_image');
 }
}
