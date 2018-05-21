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
        return view('auth.register');
    }

    public function login(){
        return view('auth.login');
    }


    //
    // other
    public function about(){
        return view('other.about');
    }

    public function contactUs() {
        return view('other.contactUs');
    }
    
    // user
    public function profile() {
        return view('user.userProfile');
    }

    public function editProfile() {
        return view('user.userEdit');
    }
}
