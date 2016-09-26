<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthenticationController extends Controller
{
  public function checkAccessToken($access_token){
    $isSuccess = DB::table('authentications')
                  ->where('access_token', $access_token)
                  ->pluck('access_token')
                  ->first();

    return !empty($isSuccess);
  }
  
}
