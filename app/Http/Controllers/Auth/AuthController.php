<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ValidatesRequests;

    public function login() {
        return view('auth.login');
    }

    public function postLogin(Request $request) {
        if (Auth::attempt(['username' => $request->input('username'), 'password' => $request->input('password')])) {
            return redirect()->route('home');
        }
    }

    public function logout() {
        // Destroy session token

        // Redirect home
    }
}
