<?php

namespace App\Http\Controllers;


class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
}