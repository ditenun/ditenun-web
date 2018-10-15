<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

final class Generate extends Model{

  public function createNewItem(array $data){
    DB::table('generates')->insert(
      [
        'idMotif' => $data['idMotif'],
        'generateFile' => $data['generateFile'],
        'nama_generate' => $data['nama_generate']
        //TODO : lengkapi
      ]);
  }

  public function scopeSaySomething(){
    echo "KRISTIK BRO !";
  }
}
