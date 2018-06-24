<?php

namespace App\Http\Controllers;

use App\Http\Enums\ImageCategories;
use App\Http\Models\DownloadFiles;
use App\Http\Models\GameBadges;
use App\Http\Models\GameJams;
use App\Http\Models\Images;
use App\Http\Models\Navigations;
use App\Http\Interfaces\IGameSubmission;
use App\Http\Models\Reports;
use Illuminate\Http\Request;
use App\Http\Models\GameSubmissions;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class GameSubmissionController extends Controller implements IGameSubmission
{

    private $viewData;

    public function oneGameSubmission($id)
    {
        if (!preg_match("/^\d+$/", $id)) {
            return back()->with('message', 'Invalid game submission id.');
        }

        $gameSubmissions = new GameSubmissions();
        $gameBadges = new GameBadges();
        $gameSubmissions->increaseViews($id);
        $this->viewData["gameSubmission"] = $gameSubmissions->getOne($id);
        $this->viewData["gameSubmissionScreenShots"] = $gameSubmissions->getScreenShots($id);
        $this->viewData["gameSubmissionDownloadFiles"] = $gameSubmissions->getDownloadFiles($id);
        $this->viewData["gameBadgesList"] = $gameBadges->getAll();

        return view('gameSubmissions.oneGameSubmission', $this->viewData);
    }

    //
    // this function is used as AJAX and normal REQUEST handler
    public function getFilteredGames(Request $request)
    {

        $page = empty(Input::get("page")) ? 1 : Input::get("page");
        $sortBy = empty(Input::get("sort")) ? "new" : Input::get("sort");
        $sort["name"] = "createdAt";
        $sort["direction"] = "desc";

        switch ($sortBy) {
            case "old":
                $sort["direction"] = "asc";
                break;
            case "top":
                $sort["name"] = "rating";
                break;
            case "views":
                $sort["name"] = "numOfViews";
                break;
            case "download":
                $sort["name"] = "numOfDownloads";
                break;
        }

        $games = new GameSubmissions();
        // todo: add combobox games per page 6 9 12 all?
        $getGames = $games->get(($page - 1) * 9, 9, $sort);

        $this->viewData["games"] = $getGames;
        $this->viewData["gamesCount"] = $games->count();
        $this->viewData["currentPage"] = $page;
        $this->viewData["currentSort"] = $sortBy;

        if ($request->ajax()) {
            return view('ajax.loadGames', $this->viewData)->render();
        }

        //
        // add navigagtion for page only if not ajax
        //$this->setupNavigation();

        return view('gameSubmissions.games', $this->viewData);
    }

    public function insert(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'tbTitle' => 'required|regex:/^[a-zA-Z0-9\s]+$/|min:3',
            'taDescription' => 'required|regex:/^[\w\.\s\,\"\'\!\?\:\;]+$/',
            'fCoverImage' => 'required|max:2000|mimes:jpg,jpeg,png',
            'fScreenShots.*' => 'required|max:2000|mimes:jpg,jpeg,png',
            'soGamePlatform' => 'required',
            'fGameFiles' => 'required|max:2000|mimes:zip,rar',
            'hIdGameJam' => 'required',
        ]);

        $validation->setAttributeNames([
            'tbTitle' => 'title',
            'taDescription' => 'description',
            'fCoverImage' => 'cover image',
            'fScreenShots' => 'screen shot',
            'soGamePlatform' => 'game platform',
            'fGameFiles' => 'game file',
        ]);

        if ($validation->fails()) {
            return back()->withInput()->withErrors($validation);
        }

        $gameJams = new GameJams();
        $gameSubmissions = new GameSubmissions();

        $gameJamId = $request->get('hIdGameJam');

        $gj = $gameJams->getById($gameJamId);
        if (empty($gj)) {
            //game jam doesn't exist
            return back()->withInput()->with('message', 'Game jam doesn\'t exist!');
        }

        //check if game jam hasn't pass end date
        if ($gj->endDate < time()) {
            return back()->withInput()->with('message', 'Game jam already ended!');
        }

        //
        $idUser = session()->get('user')[0]->idUser;
        if (!$gameJams->userAlreadyJoined($idUser, $gameJamId)) {
            return back()->withInput()->with('message', 'You have not joined this game jam!');
        }

        if (!empty($gameSubmissions->getByUserAndGameJam($idUser, $gameJamId))) {
            return back()->withInput()->with('message', 'You have already submitted your game!');
        }


        //this should be file manager but its ok for now
        $imagesManager = new Images();

        $fScreenShotsPhotos = $request->file('fScreenShots');
        if (count($fScreenShotsPhotos) > 8) {
            return back()->withInput()->with('error', 'There is more then 8 screen shoots!');
        }
        $screenShotPhotosIds = [];
        foreach ($fScreenShotsPhotos as $photo) {
            $screenShotPhotosIds[] = $imagesManager->saveImageAndGetId(ImageCategories::$SCREENSHOT, 'Game screen shot', $photo);
        }

        //save them

        $fCoverImage = $request->file('fCoverImage');
        $fCoverImageId = $imagesManager->saveImageAndGetId(ImageCategories::$COVER, 'Cover image', $fCoverImage);
        // save cover image
        // save teaser id as same as cover image for now

        //
        // save zip or rar file
        $fGameFile = $request->file('fGameFiles');
        $fGameFilePath = $imagesManager->saveFileInFolder(null, $fGameFile);
        $downloadFilesManager = new DownloadFiles();

        $fInfo = $fGameFile->getClientOriginalName();
        $fGameFileId = $downloadFilesManager->insertGetId([
            "path" => $fGameFilePath,
            "name" => pathinfo($fInfo, PATHINFO_FILENAME),
            "size" => filesize($fGameFilePath),
            "createdAt" => time(),
            "idPlatform" => $request->get('soGamePlatform'),
            "fileExtension" => pathinfo($fInfo, PATHINFO_EXTENSION),
        ]);
        //save it in vezna tabela

        $timeCreatedAt = time();

        $gameSubmissionsManager = new GameSubmissions();
        $idGameSubmission = $gameSubmissionsManager->insertGetId([
            "idGameJam" => $request->get('hIdGameJam'),
            "idTeaserImage" => $fCoverImageId,
            "idCoverImage" => $fCoverImageId,
            "idUserCreator" => $idUser,
            "description" => $request->get('taDescription'),
            "createdAt" => $timeCreatedAt,
            "editedAt" => $timeCreatedAt,
            "numOfViews" => 0,
            "numOfDownloads" => 0,
            "isBlocked" => 0,
            "numberOfVotes" => 0,
            "sumOfVotes" => 0,
            "title" => $request->get('tbTitle'),
            "isWinner" => 0,
        ]);

        //saving screen shots to table
        foreach ($screenShotPhotosIds as $ssId) {
            $imagesManager->insertScreenShots($idGameSubmission, $ssId);
        }

        //saving download file
        $gameSubmissionsManager->saveRelationshipWithDownloadFile($idGameSubmission, $fGameFileId);


        //save game categories
        $cbGameCategories = $request->get('cbCategories');
        foreach ($cbGameCategories as $c) {
            $gameSubmissionsManager->saveGameCategories([
                "idGameSubmission" => $idGameSubmission,
                "idCategory" => $c,
            ]);
        }


        return redirect('/game-jams/' . $gameJamId)->with('message', 'Successfuly created Game Submission');
    }

    public function edit(Request $request, $id)
    {
        if (!preg_match("/^\d+$/", $id)) {
            return back()->with('message', 'Invalid game submission id.');
        }

        $validation = Validator::make($request->all(), [
            'tbTitle' => 'required|regex:/^[a-zA-Z0-9\s]+$/|min:3',
            'taDescription' => 'required|regex:/^[\w\.\s\,\"\'\!\?\:\;]+$/',
            'fCoverImage' => 'max:2000|mimes:jpg,jpeg,png',
            'fScreenShots.*' => 'max:2000|mimes:jpg,jpeg,png',
            'soGamePlatform' => 'required',
            'fGameFiles' => 'max:2000|mimes:zip,rar',
            'hIdGameSubmission' => 'required',
        ]);

        $validation->setAttributeNames([
            'tbTitle' => 'title',
            'taDescription' => 'description',
            'fCoverImage' => 'cover image',
            'fScreenShots' => 'screen shot',
            'soGamePlatform' => 'game platform',
            'fGameFiles' => 'game file',
        ]);

        if ($validation->fails()) {
            return back()->withInput()->withErrors($validation);
        }


        //check if hidden game id is same as URL game id param
        if ($id != $request->get('hIdGameSubmission')) {
            return Redirect::back()->withInput()->with('message', 'This game doesn\'t exist!');
        }


        $gameSubmissions = new GameSubmissions();

        # does game exist
        $gameSubData = $gameSubmissions->getById($id);

        if (empty($gameSubData)) {
            return Redirect::back()->withInput()->with('message', 'This game doesn\'t exist!');
        }

        # is this user creator
        $idUser = session()->get('user')[0]->idUser;
        if ($gameSubData->idUserCreator != $idUser) {
            return Redirect::back()->withInput()->with('message', 'You cannot edit this game!');
        }


        //data to save
        $gsUpdateData = [];


        $imagesManager = new Images();
        // images to save

        $fCoverImage = $request->file('fCoverImage');
        $fCoverImageId = null;
        if (!empty($fCoverImage)) {
            $fCoverImageId = $imagesManager->saveImageAndGetId(ImageCategories::$COVER, 'Cover image', $fCoverImage);
            $gsUpdateData["idTeaserImage"] = $fCoverImageId;
            $gsUpdateData["idCoverImage"] = $fCoverImageId;
        }
        //if fcover image id exist concat replace data


        // - title
        // - description
        $gsUpdateData["title"] = $request->get('tbTitle');
        $gsUpdateData["description"] = $request->get('taDescription');


        // - category list (delete all and then insert selected ones)
        $gameSubmissions->removeAllCategories($id);
        $cbGameCategories = $request->get('cbCategories');
        foreach ($cbGameCategories as $c) {
            $gameSubmissions->saveGameCategories([
                "idGameSubmission" => $id,
                "idCategory" => $c,
            ]);
        }

        // - game platform

        $fGameFile = $request->file('fGameFiles');
        $downloadFilesManager = new DownloadFiles();
        if (!empty($fGameFile)) {


            $fGameFilePath = $imagesManager->saveFileInFolder(null, $fGameFile);

            $fInfo = $fGameFile->getClientOriginalName();
            $fGameFileId = $downloadFilesManager->insertGetId([
                "path" => $fGameFilePath,
                "name" => pathinfo($fInfo, PATHINFO_FILENAME),
                "size" => filesize($fGameFilePath),
                "createdAt" => time(),
                "idPlatform" => $request->get('soGamePlatform'),
                "fileExtension" => pathinfo($fInfo, PATHINFO_EXTENSION),
            ]);

            $gameSubmissions->removeRelationshipWithDownloadFile($id);
            $gameSubmissions->saveRelationshipWithDownloadFile($id, $fGameFileId);
        } else {
            $idDownloadFile = $gameSubmissions->getDownloadFileIdByGameId($id);
            $downloadFilesManager->update($idDownloadFile->idDownloadFile, [
                "idPlatform" => $request->get('soGamePlatform'),
            ]);
        }

        /*
         *  This is section for saving screen shots
         *  This should be changed, but for know its ok
         * */

        $fScreenShotsPhotos = $request->file('fScreenShots');
        if (count($fScreenShotsPhotos) > 8) {
            return back()->withInput()->with('error', 'There is more then 8 screen shoots!');
        }
        $screenShotPhotosIds = [];
        foreach ($fScreenShotsPhotos as $photo) {
            $screenShotPhotosIds[] = $imagesManager->saveImageAndGetId(ImageCategories::$SCREENSHOT, 'Game screen shot', $photo);
        }

        //remove all files
        $imagesManager->removeScreenShots($id);

        //saving screen shots to table
        foreach ($screenShotPhotosIds as $ssId) {
            $imagesManager->insertScreenShots($id, $ssId);
        }



        //
        // update data
        $gameSubmissions->update($id, $gsUpdateData);

        //dd("cool");
        return Redirect::back()->with('message', 'Successfuly updated!');
    }

    public function delete(Request $request, $id)
    {
        $idUser = session()->get('user')[0]->idUser;

        $gameJams = new GameJams();
        $gameSubmissions = new GameSubmissions();

        if ($gameSubmissions->exist($id)) {
            $gsData = $gameSubmissions->getById($id);

            if ($gsData->idUserCreator != $idUser || $gsData->isBlocked == 1) {
                return Redirect::back()->withInput()->with('message', "You can't delete this game submission.");
            } else if ($gameJams->getById($gsData->idGameJam)->endDate < time()) {
                return Redirect::back()->withInput()->with('message', 'You can\'t delete an active game jam.');
            } else {
                $gameSubmissions->update($id, ["isBlocked" => 1]);
                return Redirect::to('/')->withInput()->with('message', "Game deleted successfully.");
            }
        } else {
            return Redirect::back()->withInput()->with('message', "Selected game doesn\'t exist!");
        }
    }

    public function downloadFile(Request $request, $idDownloadFile)
    {
        if (!preg_match("/^\d+$/", $idDownloadFile)) {
            return back()->with('message', 'Invalid download file id.');
        }

        $downloadFilesManager = new DownloadFiles();
        $downloadFile = $downloadFilesManager->getById($idDownloadFile);
        if (empty($downloadFile)) {
            return back()->with('message', 'Download file doesn\'t exist.');
        }

        $filePath = storage_path($downloadFile->path);
        if (file_exists($filePath)) {
            return back()->with('message', 'Download file doesn\'t exist.');
        }

        $gameSubmission = new GameSubmissions();
        $gsData = $gameSubmission->getGameIdByDownloadFileId($idDownloadFile);
        $gameSubmission->increment($gsData->idGameSubmission, 'numOfDownloads');

        $fileName = $downloadFile->name . '.' . $downloadFile->fileExtension;
        $download_path = (public_path() . '/' . $downloadFile->path);

        return response()->download($download_path, $fileName);
    }

    public function report(Request $request){
        $validation = Validator::make($request->all(), [
            'taReason' => 'required|regex:/^[\w\.\s\,\"\'\!\?\:\;]+$/',
            'gameId' => 'required',
        ]);

        $validation->setAttributeNames([
            'taReason' => 'reason',
            'gameId' => 'game',
        ]);

        if ($validation->fails()) {
            return back()->withInput()->withErrors($validation);
        }

        $reason = $request->get('taReason');
        $idGame = $request->get('gameId');
        $idUser = session()->get('user')[0]->idUser;

        //if game exists
        $gameSubmissions = new GameSubmissions();
        if (!$gameSubmissions->exist( $idGame )) {
            return back()->withInput()->with('message', 'Game doesn\'t exist.');
        }

        //da nije vec reportovo
        $reportManager = new Reports();
        $hasReported = $reportManager->userHasReportedGame($idGame, $idUser);

        if($hasReported){
            return back()->withInput()->with('message', 'You already reported this game.');
        }

        //save it
        $reportManager->insertGetId([
            "reason"=> $reason,
            "idUserCreator"=> $idUser,
            "idReportObject"=> $idGame,
            "createdAt"=> time(),
            "solved"=> 0,
        ]);

        return back()->with('message', 'You have successfully reported the game.');
    }

    /*private function setupNavigation(){
        $navs = new Navigations();
        $this->viewData['navigation'] = $navs->getAllSortedByPosition();
    }*/
}
