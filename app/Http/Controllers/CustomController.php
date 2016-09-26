<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomController extends Controller
{
  public function stuff(Request $request){
    return response()->json(array('error' => true,
      'message'=>'The path doesnt exists'),
      404);
  }
}
