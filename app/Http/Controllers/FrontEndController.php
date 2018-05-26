<?php

namespace App\Http\Controllers;

use App\Http\Models\Navigations;
use App\Http\Models\Roles;
use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    private $viewData;

    public function __construct()
    {
        //todo
        $navs = new Navigations();
        $this->viewData['navigation'] = $navs->getAllSortedByPosition();
    }

    //
    // game jams
    public function gameJams(){
        //todo
        //move to own controller
        return view('gameJams.gameJams', $this->viewData);
    }

    public function oneGameJam($id){
        return view('gameJams.oneGameJam', $this->viewData);
    }

    public function createGameJam(){
        return view('gameJams.createGameJam', $this->viewData);
    }

    public function editGameJam($id){
        return view('gameJams.editGameJam', $this->viewData);
    }
    //
    // games submissions views
    public function games(){
        //todo
        //move to own controller
        return view('gameSubmissions.games', $this->viewData);
    }

    public function createGameSubmission(){
        //todo
        //move to own controller
        return view('gameSubmissions.createGameSubmission', $this->viewData);
    }
    public function oneGameSubmission($id){
        //todo
        //move to own controller
        return view('gameSubmissions.oneGameSubmission', $this->viewData);
    }
    public function editGameSubmission($id){
        //todo
        //move to own controller
        return view('gameSubmissions.editGameSubmission', $this->viewData);
    }


    //
    // auth 
    public function register(){
        $roles = new Roles();
        $userRoles = $roles->getAllAvailable();

        $this->viewData['userAvailableRoles'] = $userRoles;
        return view('auth.register', $this->viewData);
    }

    public function login(){
        return view('auth.login', $this->viewData);
    }


    //
    // other
    public function about(){
        return view('other.about', $this->viewData);
    }

    public function contactUs() {
        return view('other.contactUs', $this->viewData);
    }
    
    // user
    public function profile() {
        return view('user.userProfile', $this->viewData);
    }

    public function editProfile() {
        return view('user.userEdit', $this->viewData);
    }
}
