<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

final class Tenun extends Model{

  public function createNewItem(array $data){
    DB::table('tenuns')->insert(
      [
        'nama_tenun' => $data['nama_tenun'],
        'asal_tenun' => $data['asal_tenun']
        //TODO : lengkapi
      ]);
  }

  public function scopeSaySomething(){
    echo "YAWWWW !";
  }
}
