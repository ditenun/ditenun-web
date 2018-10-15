<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MotifTenun;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use File;

class GenerateController extends Controller{

  public function __construct()
  {  }

  public function getListGenerate(){
    $listGenerate = DB::table('generates')->get();
    if(!count($listGenerate))
    return response()->json(array('error' => false,
      'message'=>'Get item failed, no item found',
      'data' => $listGenerate),
      200);


      return response()->json(array('error' => false,
        'message'=>'Get list item success',
        'data' => $listGenerate,),
        200);
  }

}
