<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MotifItemController extends Controller
{
  public function view($id){
    $motifItem = DB::table('motif_tenuns')->where('id', $id)->first();

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

  public function getListMotif(Request $request){
    $size = $request->input('size', 20);
    $cursor = $request->input('cursor');

    if($size == 'all')
      $listMotifTenuns = DB::table('motif_tenuns')->get();
    else
      $listMotifTenuns = DB::table('motif_tenuns')->skip($cursor)->take($size)->get();

    if(!count($listMotifTenuns))
    return response()->json(array('success' => false,
      'message'=>'Get item failed, no item found',
      'data' => $listMotifTenuns),
      404);

    if(count($listMotifTenuns) < 20){
      $pagination = [
          'is_exist_next' => false,
        ];
    }
    else{
      $cursor += $size;

      $pagination = [
          'is_exist_next' => true,
          'next_cursor' => $cursor,
          'size' => count($listMotifTenuns)
        ];
      }

    return response()->json(array('error' => false,
      'message'=>'Get list item success',
      'data' => $listMotifTenuns,
      'pagination' => $pagination),
      200);
  }

  protected function checkInput($input)
  {
      $data = $input;

      //TODO : Check the request pls

      return $data;
  }

  public function createNewMotifItem(Request $request){
    $data = $this->checkInput($request->all());
    $token = $request->header('Authorization');

    if(!empty($data['article_id'])) {
      //TODO : Update row
    } else {
      //TODO : Create row
      if (true) {
          return response()->json(['success' => 'New item has been submitted'], 200);
      } else {
        return response()->json(['error' => 'Fail when submitting item'], 500);
      }
    }
  }
}
