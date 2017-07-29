<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\AuthenticatesUser;

class AuthController extends Controller
{
    use ValidatesRequests;

    public function login() {
        return view('auth.login');
    }

    public function postLogin(AuthenticatesUser $auth) {
        $auth->authorize();
    }

    public function logout() {
        // Destroy session token

        // Redirect home
    }
}
