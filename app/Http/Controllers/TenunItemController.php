<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use \App\Models\Tenun;

class TenunItemController extends Controller
{
  public function view($id){
    $motifItem = DB::table('tenuns')->where('id_tenun', $id)->first();

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

  protected function checkInput($input)
  {
      $data = $input;

      //TODO : Check the request pls (Add validator)

      return $data;
  }

  public function createNewTenunItem(Request $request){
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

  public function getListTenun(Request $request){
    $size = $request->input('size', 20);
    $cursor = $request->input('cursor');

    $listTenun = DB::table('tenuns')->skip($cursor)->take($size)->get();


    if(!count($listTenun))
      return response()->json(array('success' => false,
        'message'=>'Get item failed, no item found',
        'data' => $listTenun),
        404);

    if(count($listTenun) < 20) {
      $pagination = [
          'is_exist_next' => false,
        ];
    }
    else {
      $cursor += $size;

      $pagination = [
        'is_exist_next' => true,
        'next_cursor' => $cursor,
        'size' => $size
      ];
    }


    return response()->json(array('error' => false,
      'message'=>'Get list item success',
      'data' => $listTenun,
      'pagination' => $pagination),
      200);
  }
}
