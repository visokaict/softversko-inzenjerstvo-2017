<?php

namespace App\Http\Controllers;
use App\Http\Models\GameCategories;
use App\Http\Models\Navigations;
use App\Http\Models\Platforms;
use App\Http\Models\Polls;
use App\Http\Models\Roles;
use Illuminate\Http\Request;
use App\Http\Models\Users;
use App\Http\Models\GameCriteria;
use App\Http\Models\GameSubmissions;
use App\Http\Models\GameJams;
use Illuminate\Support\Facades\Redirect;

class FrontEndController extends Controller
{
    private $viewData = [];
    public function __construct()
    {
        //$navs = new Navigations();
        //$this->viewData['navigation'] = $navs->getAllSortedByPosition();
    }
    //
    // game jams
    public function gameJams(Request $request) {
        //todo
        //move to own controller

        $page = empty($request->get("page")) ? 1 : $request->get("page");

        $gameJams = new GameJams();

        $gameJamsInProgress = $gameJams->getFilteredGameJams("progress", ($page - 1) * 6, 6);
        $this->viewData["inProgressGameJams"] = $gameJamsInProgress["result"];
        $this->viewData["gamesJamsInProgressCount"] = $gameJamsInProgress["count"];
        $this->viewData["currentPageGameJamsInProgress"] = $page;

        $gameJamsUpcoming = $gameJams->getFilteredGameJams("upcoming", ($page - 1) * 6, 6);
        $this->viewData["upcomingGameJams"] = $gameJamsUpcoming["result"];
        $this->viewData["gamesJamsUpcomingCount"] = $gameJamsUpcoming["count"];
        $this->viewData["currentPageGameJamsUpcoming"] = $page;

        if ($request->ajax()) {
            if($request->get("gameJamsType") === "inProgress") {
                return view('ajax.loadGameJamsInProgress', $this->viewData)->render();
            }
            else{
                return view('ajax.loadGameJamsUpcoming', $this->viewData)->render();
            }
        }

        return view('gameJams.gameJams', $this->viewData);
    }
    public function oneGameJam($id){
        if (!preg_match("/^\d+$/", $id)) {
            return back()->with('message', 'Invalid game jam id.');
        }

        $gameJams = new GameJams();

        $gameJam = $gameJams->getById($id);

        if(empty($gameJam)){
            return Redirect::back()->withInput()->with("message", "Game jam doesn't exist!");
        }

        $this->viewData["userCanEditAndDeleteGameJam"] = $this->viewData["userJoinedGameJam"]  = false;

        if(session()->has('user')) {
            $idUser = session()->get('user')[0]->idUser;
            $this->viewData["userJoinedGameJam"] = $gameJams->userAlreadyJoined($idUser, $id);

            if($gameJam->startDate > time()){
                $this->viewData["userCanEditAndDeleteGameJam"] = $gameJams->userOwnsGameJam($idUser, $id);
            }
        }

        $gameJams->increaseViews($id);

        $this->viewData["gameJam"] = $gameJams->getOne($id);
        
        return view('gameJams.oneGameJam', $this->viewData);
    }
    public function createGameJam(){
        $gameCriteria = new GameCriteria();
        $this->viewData['criteria'] = $gameCriteria->getAll();
        return view('gameJams.createGameJam', $this->viewData);
    }
    public function editGameJam($id){
        if (!preg_match("/^\d+$/", $id)) {
            return back()->with('message', 'Invalid game jam id.');
        }

        $gameJams = new GameJams();
        $gameCriteria = new GameCriteria();

        $gameJam = $gameJams->getOne($id);

        $this->viewData["userCanEditGameJam"] = false;

        if($gameJam->startDate < time()){
            return Redirect::back()->withInput()->with("message", "You can no longer edit this game jam!");
        }
        else {
            if(session()->has('user')){
                $idUser = session()->get('user')[0]->idUser;
                if(!$gameJams->userOwnsGameJam($idUser, $id)){
                    return Redirect::back()->withInput()->with("message", "You can't edit this game jam!");
                }
            }
        }

        foreach($gameJam->criteria as $c) {
            $this->viewData["gameHasCriteria"][] = $c->idGameCriteria;
        }

        $this->viewData["gameCriteria"] = $gameCriteria->getAll();
        $this->viewData["gameJam"] = $gameJams->getOne($id);

        return view('gameJams.editGameJam', $this->viewData);
    }
    //
    // games submissions views
    public function games(Request $request) {
        //todo
        //move to own controller
    } //this needs to move in GameSubmission controller

    public function createGameSubmission($idGameJam){
        //todo
        //move to own controller
        if (!preg_match("/^\d+$/", $idGameJam)) {
            return back()->with('message', 'Invalid game jam id.');
        }

        $gameJams = new GameJams();
        $gameSubmissions = new GameSubmissions();

        #$gameJam = $gameJams->getById($idGameJam);
        $gameJamExist = $gameJams->exist($idGameJam);
        if(!$gameJamExist){
            return Redirect::back()->withInput()->with('message', 'This game jam doesn\'t exist!');
        }

        if(session()->has('user')){
            $idUser = session()->get('user')[0]->idUser;

            if(!$gameJams->userAlreadyJoined($idUser, $idGameJam)){
                return Redirect::back()->withInput()->with('message', 'You have not joined this game jam!');
            }

            if(!empty($gameSubmissions->getByUserAndGameJam($idUser, $idGameJam))) {
                return Redirect::back()->withInput()->with('message', 'You have already submitted your game!');
            }

        }

        $gameCategories = new GameCategories();
        $gamePlatform = new Platforms();

        $this->viewData["gameJamId"] = $idGameJam;
        $this->viewData["gameCategories"] = $gameCategories->getAll();
        $this->viewData["gamePlatforms"] = $gamePlatform->getAll();




        return view('gameSubmissions.createGameSubmission', $this->viewData);
    }
    //removed one game submission get route from frontend

    public function editGameSubmission($id){
        //todo
        //move to own controller
        if (!preg_match("/^\d+$/", $id)) {
            return back()->with('message', 'Invalid game submission id.');
        }

        $gameSubmissions = new GameSubmissions();

        # does game exist
        $gameSubData = $gameSubmissions->getById($id);
        if(empty($gameSubData)){
            return Redirect::back()->withInput()->with('message', 'This game doesn\'t exist!');
        }

        # is this user creator
        $idUser = session()->get('user')[0]->idUser;
        if($gameSubData->idUserCreator != $idUser){
            return Redirect::back()->withInput()->with('message', 'You cannot edit this game!');
        }


        $gameCategories = new GameCategories();
        $gamePlatform = new Platforms();

        $this->viewData["gameSubmissionId"] = $id;
        $this->viewData["gameCategories"] = $gameCategories->getAll();
        $this->viewData["gamePlatforms"] = $gamePlatform->getAll();
        $this->viewData["gameSubData"] = $gameSubData;
        $this->viewData["gameSubCategories"] = $gameSubmissions->getCategoriesIds($id);
        $this->viewData["gameSubPlatform"] = $gameSubmissions->getGamePlatformId($id);

        #dd($this->viewData);

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
        $poll = new Polls();
        $question = $poll->getActivePollQuestion();
        if(!empty($question)) {
            $this->viewData['pollQuestion'] = $question;
            $this->viewData['pollAnswers'] = $poll->getAnswersByQuestionId($question->idPollQuestion);
        }
        //return view('mailPages.contactUs', $this->viewData);
        return view('other.contactUs', $this->viewData);
    }
    //
    // profile
    public function profile() {
        $this->viewData['isEditButtonDisplayed'] = true;
        $users = new Users();
        
        $this->viewData['userData'] = $users->getById(session()->get('user')[0]->idUser);
        $this->viewData['userRoles'] = session()->get('roles')[0];
        return view('user.userProfile', $this->viewData);
    }
    public function editProfile() {
        $this->viewData['userData'] = session()->get('user')[0];
        $this->viewData['userRoles'] = session()->get('roles')[0];
        $roles = new Roles();
        $userRoles = $roles->getAllAvailable();
        $users = new Users();
        $userHasRolesDb = $users->getAllRoles(session()->get('user')[0]->idUser);
        $userHasRoles = [];
        $this->viewData['userAvailableRoles'] = $userRoles;
        foreach($userHasRolesDb as $e){
            if($e->name != 'admin'){
                $userHasRoles[] = $e->idRole;
            }
        }
        $this->viewData['userHasRoles'] = $userHasRoles;
        return view('user.userEdit', $this->viewData);
    }
    public function getUserProfileInfo($username)
    {
        $this->viewData['isEditButtonDisplayed'] = false;
        $user = new Users();
        $userData = $user->getByUsername($username);
        if(empty($userData))
        {
            return back()->with('message', 'Sorry but user with that username does not exist!');
        }
        $userRoles = $user->getAllRoles($userData->idUser);
        $this->viewData['userData'] = $userData;
        $this->viewData['userRoles'] = $userRoles;
        return view('user.userProfile', $this->viewData);
    }
}