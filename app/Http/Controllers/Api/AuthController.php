<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    function login (Request $request) {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $credentials = request(['email', 'password']);

        if (!auth()->attempt($credentials)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Unauthorized'
            ], 401);
        }

        $user        = auth()->user();
        $token       = $user->createToken('authToken')->accessToken;
        $user->token = $token;

        return response()->json([
            'status'  => 'success',
            'data'    => $user,
            'message' => 'User logged in successfully'
        ], 200);
    }

    function logout (Request $request) {
    }

    function register (Request $request) {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $input             = $request->all();
        $input['password'] = bcrypt($input['password']);

        $user        = User::create($input);
        $token       = $user->createToken('authToken')->accessToken;
        $user->token = $token;

        return response()->json([
            'status'  => 'success',
            'data'    => $user,
            'message' => 'User registered successfully'
        ], 200);
    }
}
