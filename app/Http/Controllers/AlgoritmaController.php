<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use \App\Models\Algoritma;

class AlgoritmaController extends Controller
{
  public function view($id){
    $algoritmaItem = DB::table('algoritmas')->where('id', $id)->first();

    if(empty($algoritmaItem))
    return response()->json(array('success' => false,
      'message'=>'Get item failed, no item found',
      'data' => $algoritmaItem),
      404);

    return response()->json(array('success' => true,
      'message'=>'Get item success',
      'data' => $algoritmaItem),
      200);
  }

  public function getListAlgoritma(Request $request){
    $listAlgoritma = DB::table('algoritmas')->get();

    if(!count($listAlgoritma))
      return response()->json(array('success' => false,
        'message'=>'Get item failed, no item found',
        'data' => $listAlgoritma),
        404);

     return response()->json(array('error' => false,
      'message'=>'Get list item success',
      'data' => $listAlgoritma),
      200);
  }

  public function getListAlgoritmaParameter(Request $request){
    $listAlgoritma = DB::table('algoritma_parameters')->get();

    if(!count($listAlgoritma))
      return response()->json(array('success' => false,
        'message'=>'Get item failed, no item found',
        'data' => $listAlgoritma),
        404);

     return response()->json(array('error' => false,
      'message'=>'Get list item success',
      'data' => $listAlgoritma),
      200);
  }

  public function getListAlgoritmaWithParameter(Request $request){
    $listAlgoritma = DB::table('algoritmas')->get();
    $listAlgoritmaParameter = DB::table('algoritma_parameters')->get();

    foreach ($listAlgoritma as $value) {
      $paramAlgo = DB::table('algoritma_parameters')->where('id_algoritma', $value->id)->get();

      $value->{"parameters"} = array();
      foreach ($paramAlgo as $key) {
        array_push($value->{"parameters"}, $key);
      }
    }

    if(!count($listAlgoritma))
      return response()->json(array('success' => false,
        'message'=>'Get item failed, no item found',
        'data' => $listAlgoritma),
        404);

     return response()->json(array('success' => true,
      'message'=>'Get list item success',
      'data' => $listAlgoritma),
      200);

  }
}
