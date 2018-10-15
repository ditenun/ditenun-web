<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

final class Kristik extends Model{

  public function createNewItem(array $data){
    DB::table('kristiks')->insert(
      [
        'sourceFile' => $data['sourceFile'],
        'kristikFile' => $data['kristikFile']
        //TODO : lengkapi
      ]);
  }

  public function scopeSaySomething(){
    echo "KRISTIK BRO !";
  }
}
