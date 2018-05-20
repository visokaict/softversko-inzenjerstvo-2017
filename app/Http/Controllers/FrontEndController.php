<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    public function gameJams(){
        return view('gameJams');
    }

    public function games(){
        return view('games');
    }

    public function register(){
        return view('register');
    }

    public function login(){
        return view('login');
    }

    public function about(){
        return view('about');
    }

    public function contactUs(){
        return view('contactUs');
    }
}
