<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTableTenuns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('jenis_tenuns', function($table)
      {
        $table->string('img_src')->nullable()->default(NULL);
      });
      Schema::table('motif_jenis_tenuns', function($table)
      {
        $table->string('img_src')->nullable()->default(NULL);
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
