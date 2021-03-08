<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\User;

/**
 * UserController
 */
class UserController extends Controller
{

  // public function __construct()
  // {
  //   $this->middleware('auth');
  // }

  public function show($id)
  {
    $user = User::find($id);

    if ($user) {
      return response()->json([
        'success' => true,
        'message' => 'User found!',
        'data' => $user
      ], 200);
    } else {
      return response()->json([
        'success' => false,
        'message' => 'User not found!',
      ], 400);
    }
  }

  public function register(Request $request){
    $name = $request->input('name');
    $email = $request->input('email');
    $no_hp = $request->input('no_hp');
    $alamat = $request->input('alamat');
    $jenis_tenun = $request->input('jenis_tenun');
    $password = Hash::make($request->input('password'));
    // $apiToken = base64_encode(str_random(40));

    $register = User::create([
      'name' => $name,
      'email' => $email,
      'no_hp' => $no_hp,
      'alamat' => $alamat,
      'jenis_tenun' => $jenis_tenun,
      'password' => $password,
      // 'api_token' => $apiToken,
    ]);

    if ($register) {
      return response()->json([
        'succes' => true,
        'message' => 'Register Success!',
        'data' => [$register],
      ], 201);
    } else {
      return response()->json([
        'succes' => false,
        'message' => 'Register Fail!',
        'data' => ''
      ], 400);
    }

  }

  public function login(Request $request){
		$username = $request->input('username');
		$password = $request->input('password');

		if(filter_var($username, FILTER_VALIDATE_EMAIL)) {
		    //user sent their email
		    $email = User::where('email', $username)->first();

		    if (Hash::check($password, $email->password)) {
				// $apiToken = base64_encode(str_random(40));

				// $user->update([
				// 	'api_token' => $apiToken
				// ]);

				return response()->json([
					'error' => false,
					'message' => 'Login Success!',
					'data' => [$email],
				], 200);
			} else {
				return response()->json([
					'error' => true,
					'message' => 'Login Fail!',
					'data' => ''
				], 400);
			}
		} else {
		    //they sent their phone number instead
		    $phone = User::where('no_hp', $username)->first();
			if (Hash::check($password, $phone->password)) {
				// $apiToken = base64_encode(str_random(40));

				// $user->update([
				// 	'api_token' => $apiToken
				// ]);

				return response()->json([
					'error' => false,
					'message' => 'Login Success!',
					'data' => [$phone],
				], 200);
			} else {
				return response()->json([
					'error' => true,
					'message' => 'Login Fail!',
					'data' => ''
				], 400);
			}
		}
	}

  public function loginByEmail(Request $request){
    $email = $request->input('email');
    $password = $request->input('password');

    $user = User::where('email', $email)->first();

    if (Hash::check($password, $user->password)) {
      // $apiToken = base64_encode(str_random(40));

      // $user->update([
      //         'api_token' => $apiToken
      // ]);

      return response()->json([
              'succes' => true,
              'message' => 'Login Success!',
              'data' => [
                      'user' => $user,
                      // 'api_token' => $apiToken
              ],
      ], 201);
    } else {
      return response()->json([
              'succes' => false,
              'message' => 'Login Fail!',
              'data' => ''
      ], 400);
    }
  }

  public function loginByPhone(Request $request){
    $no_hp = $request->input('no_hp');
    $password = $request->input('password');

    $user = User::where('no_hp', $no_hp)->first();

    if (Hash::check($password, $user->password)) {
      // $apiToken = base64_encode(str_random(40));

      // $user->update([
      //         'api_token' => $apiToken
      // ]);

      return response()->json([
        'succes' => true,
        'message' => 'Login Success!',
        'data' => [
                'user' => $user,
                // 'api_token' => $apiToken
        ],
      ], 201);
    } else {
      return response()->json([
              'succes' => false,
              'message' => 'Login Fail!',
              'data' => ''
      ], 400);
    }
  }
}
