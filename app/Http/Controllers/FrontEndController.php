<?php

namespace App\Http\Controllers;

use App\Http\Models\Roles;
use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    //
    // game jams
    public function gameJams(){
        //todo
        //move to own controller
        return view('gameJams.gameJams');
    }

    public function oneGameJam($id){
        return view('gameJams.oneGameJam');
    }

    public function createGameJam(){
        return view('gameJams.createGameJam');
    }

    public function editGameJam($id){
        return view('gameJams.editGameJam');
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
    public function editGameSubmission($id){
        //todo
        //move to own controller
        return view('gameSubmissions.editGameSubmission');
    }


    //
    // auth 
    public function register(){
        $roles = new Roles();
        $userRoles = $roles->getAllAvailable();
        return view('auth.register', [
            'userAvailableRoles' => $userRoles
        ]);
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
