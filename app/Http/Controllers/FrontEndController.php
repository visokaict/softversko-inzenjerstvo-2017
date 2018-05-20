<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    public function gameJams(){
        //todo
        //move to own controller
        return view('gameJams');
    }


    //
    // games submissions views
    public function games(){
        //todo
        //move to own controller
        return view('gameSubmissions.games');
    }

    public function createGameSubmission(){
        //todo
        //move to own controller
        return view('gameSubmissions.createGameSubmission');
    }
    public function oneGameSubmission($id){
        //todo
        //move to own controller
        return view('gameSubmissions.oneGameSubmission');
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

    public function contactUs() {
        return view('contactUs');
    }

    
    //
    // profile
    public function profile() {
        //todo
        //move to own controller
        return view('userProfile');
    }

    public function editProfile() {
        //todo
        //move to own controller
        return view('userEdit');
    }
}
