<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Monolog\Handler\FlowdockHandler;

class AuthController extends Controller
{
    public function login() {
        return view('auth.login');
    }

    public function postLogin() {
        // Validate Request

        // Submit to MLF

        // Create a session token

        // Redirect home
    }

    public function logout() {
        // Destroy session token

        // Redirect home
    }
}
