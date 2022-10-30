<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email'     => 'required|email',
            'password'  => 'required|min:8',
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(),400);
        }

        $user = User::where('email',$request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password))
        {
            return response()->json([
                'success' => false,
                'message' => 'Email atau Password salah!',
             ], 409);
        }else{
            return response()->json([
                'success' => true,
                'message' => 'Login berhasil!',
                'data'    => $user,
                'token'   => $user->createToken('authToken')->accessToken
            ], 200);
        }
    }

    public function logout(Request $request){

        $removeToken = $request->user()->tokens()->delete();

        if($removeToken) {
            return response()->json([
                'success' => true,
                'message' => 'Logout berhasil!',
            ]);
        }
    }
}
