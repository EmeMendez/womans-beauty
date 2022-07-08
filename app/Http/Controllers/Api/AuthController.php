<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AuthLoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(AuthLoginRequest $request)
    {
      $credentials = [
        'email'     => $request->email,
        'password'  => $request->password
      ];
      
      $user = User::where('email', $request->email)->first();
      
      if(!$user || !Hash::check($request->password, $user->password)){
        return throw ValidationException::withMessages([
          'email' => 'Estas credenciales no coinciden con nuestros registros.'
        ]);
      }

      $devide_name = $request->device_name ? $request->device_name : 'desconocido';

      return response()->json([
        'token' => $user->createToken($devide_name)->plainTextToken
      ], 200);
    }
}
