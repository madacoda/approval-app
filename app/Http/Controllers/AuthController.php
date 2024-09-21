<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    function login() {
        return view('auth.login');
    }

    function postLogin(Request $request) {
        $input = $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        if (auth()->attempt($input)) {
            return redirect()->route('dashboard');
        }

        $validator = Validator::make([], []);
        $validator->errors()->add('email', 'Invalid email or password');
        $validator->errors()->add('password', 'Invalid email or password');

        if ($validator->errors()->isNotEmpty()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    function logout() {
        auth()->logout();
        return redirect()->route('login');
    }

    function register() {
        return view('auth.register');
    }

    function postRegister(Request $request) {
        $input = $request->validate([
            'name'     => 'required',
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $input             = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user              = User::create($input);

        return redirect()->route('login')->with([
            'status'  => 'success',
            'message' => 'User registered successfully',
        ]);
    }
}
