<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function renderSignIn()
    {
        return view('sign-in');
    }

    public function renderSignUp()
    {
        return view('sign-up');
    }
}
