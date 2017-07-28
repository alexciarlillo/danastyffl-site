<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionsController extends Controller
{
    public function create() {
        return view('sessions.create');
    }

    public function store(Request $request) {
        // Validate Request

        // Log In User

        // Redirect


        $username = $request->input('username');
        $password = $request->input('password');

        dd($username);
    }

    public function destroy(Request $request) {
        
    }
}
