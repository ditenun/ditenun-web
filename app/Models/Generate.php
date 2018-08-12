<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

final class Generate extends Model{

  public function createNewItem(array $data){
    DB::table('generate')->insert(
      [
        'idMotif' => $data['idMotif'],
        'generateFile' => $data['generateFile']
        //TODO : lengkapi
      ]);
  }

  public function scopeSaySomething(){
    echo "KRISTIK BRO !";
  }
}
