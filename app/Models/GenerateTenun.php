<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

final class GenerateTenun extends Model{

  public function createNewItem(array $data){
    DB::table('generate_tenuns')->insert(
      [
        'idTenun' => $data['idTenun'],
        'generateFile' => $data['generateFile'],
        'nama_generate' => $data['nama_generate']
        //TODO : lengkapi
      ]);
  }

  public function scopeSaySomething(){
    echo "KRISTIK BRO !";
  }
}
