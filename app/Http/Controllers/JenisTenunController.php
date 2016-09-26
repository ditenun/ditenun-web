<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JenisTenunController extends Controller
{
  public function view($id){
    $motifItem = DB::table('jenis_tenuns')->where('id_jenis_tenun', $id)->first();

    if(empty($motifItem))
    return response()->json(array('success' => false,
      'message'=>'Get item failed, no item found',
      'data' => $motifItem),
      404);

    return response()->json(array('success' => true,
      'message'=>'Get motif success',
      'data' => $motifItem),
      200);
  }

  public function getListJenisTenun(Request $request){
    $listJenisTenun = DB::table('jenis_tenuns')->get();

    if(empty($listJenisTenun))
    return response()->json(array('success' => false,
      'message'=>'Get item failed, no item found',
      'data' => $listJenisTenun),
      404);

    return response()->json(array('error' => false,
      'message'=>'Get list item success',
      'data' => $listJenisTenun),
      200);

  }
}
