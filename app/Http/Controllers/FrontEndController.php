<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    public function gameJams(){
        return view('gameJams');
    }

    //
    // games submissions views
    public function games(){
        return view('gameSubmissions.games');
    }

    public function createGameSubmission(){
        return view('gameSubmissions.createGameSubmission');
    }


    //
    // auth 
    public function register(){
        return view('register');
    }

    public function login(){
        return view('login');
    }


    //
    // other
    public function about(){
        return view('about');
    }

    public function contactUs(){
        return view('contactUs');
    }

    public function profile(){
        return view('userProfile');
    }
}
