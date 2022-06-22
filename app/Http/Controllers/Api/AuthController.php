<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserLoginRequest;
use App\Models\User;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
  
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login' , 'register']]);
    }

    public function register(UserRegisterRequest $request)
    {
      $user = User::create($request->all());

      $token = auth()->login($user);

      return $this->respondWithToken($token);
    }

    public function login(UserLoginRequest $request)
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return responseJson(1 , 'Unauthorized');
        }

        return $this->respondWithToken($token);
    }

    public function me()
    {
        return responseJson(1 , 'success' , new UserResource(auth()->user()));
    }

    public function logout()
    {
        auth()->logout();

        return responseJson(1 , 'Successfully logged out');
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return responseJson(1 , 'success' , [

            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => new UserResource(auth()->user()),
        ]);
    }
}
