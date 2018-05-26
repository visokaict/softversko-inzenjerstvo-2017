<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\GameCriteria;

class FrontEndController extends Controller
{
    private $data = [];
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
        $gameCriteria = new GameCriteria();
        $this->data['criteria'] = $gameCriteria->getAll();
        return view('gameJams.createGameJam', $this->data);
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
