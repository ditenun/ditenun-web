<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

use App\Http\Controllers\AuthenticationController;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;
    protected $authController;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth, AuthenticationController $authController)
    {
        $this->auth = $auth;
        $this->authController = $authController;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
      $token = $request->header('Authorization');

      if (!empty($token) &&  $this->authController->checkAccessToken($token))
      {
          return $next($request);
      }

       return response()->json(array('error' => true,
         'message'=>'Unauthorized ¯\_(ツ)_/¯ | pstt for now use this : $2y$10$9yZpxLswvbxjIGzdS2Z0U.cnam673/GY8PZvR.tiVRR6h7TndC9BK'),
         401);
    }
}
