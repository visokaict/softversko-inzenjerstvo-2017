<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Models\GameJams;
use App\Http\Models\GameCriteria;
use App\Http\Models\Images;
use Illuminate\Support\Facades\Validator;
use Psy\Util\Json;
use Illuminate\Support\Facades\Redirect;

class GameJamController extends Controller
{

    public function getChartGameJams(Request $request) {
        $gameJamDB = new GameJams();
        $gameJamsResult = $gameJamDB->getAllWhereVotingEndDateNotFinished();

        return Json::encode($gameJamsResult);
    }

    public function getFilteredGameJams(Request $request) {
        // TODO
    }

    public function insert(Request $request) {
        $startDate = strtotime($request->get("dStartDate"));
        $endDate = strtotime($request->get("dEndDate"));
        $votingEndDate = strtotime($request->get("dVotingEndDate"));

        if($startDate < time() + 86400){
            $dateError = "Game jam must start at least 1 day from now.";
        }
        else if($endDate < $startDate + 86400){
            $dateError = "Game jam duration must be at least 1 day.";
        }
        else if($votingEndDate < $endDate + 86400){
            $dateError = "Voting period must be at least 1 day.";
        }

        if(isset($dateError)){
            return back()->withInput()->with('dateError', $dateError);
        }

        $validation = Validator::make($request->all(), [
            'tbTitle' => 'required|regex:/^[a-zA-Z0-9\s]+$/|min:3',
            'taDescription' => 'required',
            'fCoverImage' => 'required|max:2000|mimes:jpg,jpeg,png'
        ]);

        $validation->setAttributeNames([
            'tbTitle' => 'title',
            'taDescription' => 'description',
            'fCoverImage' => 'image'
        ]);

        if($validation->fails()) {
            return back()->withInput()->withErrors($validation);
        } else {
            $photo = $request->file('fCoverImage');
            $extension = $photo->getClientOriginalExtension();
            $tmp_path = $photo->getPathName();
            
            $folder = 'images/cover/';
            $file_name = time() . "." . $extension;
            $new_path = public_path($folder).$file_name;

            try {
                // insert cover image
                File::move($tmp_path, $new_path);

                $cover = new Images();
                $coverId = $cover->insert(1, 'Cover image', 'images/cover/'.$file_name);

                // others can vote, locked
                $othersCanVote = $lock = 0;

                $othersCanVote = $request->has('chbOthers') ? 1 : 0;
                $lock = $request->has('chbLock') ? 1 : 0;

                // insert game jam
                $gameJam = new GameJams();

                $gameJamId = $gameJam->insert(
                    $request->get('tbTitle'),
                    $request->get('taDescription'),
                    $coverId,
                    $startDate,
                    $endDate,
                    $votingEndDate,
                    $request->get('taContent'),
                    $lock,
                    $othersCanVote,
                    $request->session()->get('user')[0]->idUser
                );

                if(empty($gameJamId))
                {
                    return back()->withInput()->with('error', 'Game jam creation failed!');
                }

                // insert criterias
                $criterias = $request->get('chbCriteria');
                $gameCriteria = new GameCriteria();

                if(!empty($criterias)) {
                    foreach ($criterias as $criteria)
                    {
                        $gameJam->insertCriteria($gameJamId, $criteria);
                    }
                }

                return redirect('/game-jams/create')->with('message', 'Successfully created Game jam!');
            }
            catch(\Illuminate\Database\QueryException $ex){
                return redirect()->back()->withInput()->with('error', 'Database error.');
            }
            catch(\Symfony\Component\HttpFoundation\File\Exception\FileException $ex) {
                return redirect()->back()->withInput()->with('error', 'Failed to upload image!');
            }
            catch(\ErrorException $ex) {
                return redirect()->back()->withInput()->with('error', 'An error occured.');
            }
        }
    }

    public function joinUserToGameJam($idGameJam) {
        $idUser = session()->get('user')[0]->idUser;

        $gameJams = new GameJams();

        if($gameJams->exist($idGameJam)) {
            if($gameJams->userOwnsGameJam($idUser, $idGameJam)){
                return Redirect::back()->withInput()->with('message', 'You can\'t join your own Game Jam.');
            }
            if($gameJams->getById($idGameJam)->endDate < time()){
                return Redirect::back()->withInput()->with('message', 'You can no longer join this game jam.');
            }
            else if($gameJams->userAlreadyJoined($idUser, $idGameJam)) {
                return Redirect::back()->withInput()->with('message', 'You are already in this game jam!');
            }
            else {
                $result = $gameJams->joinUserToGameJam($idUser, $idGameJam);

                if(empty($result)) {
                    return Redirect::back()->withInput()->with('message', 'Failed to join game jam!');
                }
                else {
                    return Redirect::back()->withInput()->with('message', 'Congratulations, you have joined this game jam!');
                }
            }
        }
        else {
            return Redirect::back()->withInput()->with('message', 'Selected game jam doesn\'t exist :(');
        }
    }

    public function removeUserFromGameJam($idGameJam) {
        $idUser = session()->get('user')[0]->idUser;

        $gameJams = new GameJams();

        if($gameJams->exist($idGameJam)) {
            if($gameJams->userAlreadyJoined($idUser, $idGameJam)) {
                $result = $gameJams->removeUserFromGameJam($idUser, $idGameJam);
                return Redirect::back()->withInput()->with('message', 'You have left this game jam. Good bye!');
            }
            else {
                return Redirect::back()->withInput()->with('message', 'You can\'t leave because you never joined!');
            }
        }
        else {
            return Redirect::back()->withInput()->with('message', 'Selected game jam doesn\'t exist :(');
        }
    }

    public function update(Request $request) {
        $gameJams = new GameJams();
        $idGameJam = $request->get("hiddenIdGameJam");
        $gameJam = $gameJams->getById($idGameJam);

        if($gameJam->startDate < time()){
            return Redirect::back()->withInput()->with("message", "You can no longer edit this game jam!");
        }
        else {
            if(session()->has('user')){
                $idUser = session()->get('user')[0]->idUser;
                if(!$gameJams->userOwnsGameJam($idUser, $idGameJam)){
                    return Redirect::back()->withInput()->with("message", "You can't edit this game jam!");
                }
            }
        }

        $updateData = [];

        $timeOffset = $request->get("hiddenTimeOffset");
        
        $startDate = strtotime($request->get("dStartDate")) + $timeOffset;
        $endDate = strtotime($request->get("dEndDate")) + $timeOffset;
        $votingEndDate = strtotime($request->get("dVotingEndDate")) + $timeOffset;

        $updateData['startDate'] = intval($startDate);
        $updateData['endDate'] = intval($endDate);
        $updateData['votingEndDate'] = intval($votingEndDate);

        if($startDate < time() + 3600){
            $dateError = "Game jam must start at least 1 hour from now.";
        }
        else if($endDate < $startDate + 86400){
            $dateError = "Game jam duration must be at least 1 day.";
        }
        else if($votingEndDate < $endDate + 86400){
            $dateError = "Voting period must be at least 1 day.";
        }

        if(isset($dateError)){
            return back()->withInput()->with('dateError', $dateError);
        }

        $validation = Validator::make($request->all(), [
            'tbTitle' => 'required|regex:/^[a-zA-Z0-9\s]+$/|min:3',
            'taDescription' => 'required'
        ]);

        $validation->setAttributeNames([
            'tbTitle' => 'title',
            'taDescription' => 'description'
        ]);

        if($validation->fails()) {
            return back()->withInput()->withErrors($validation);
        } else {
            $updateData['title'] = $request->get('tbTitle');
            $updateData['description'] = $request->get('taDescription');
            $updateData['content'] = $request->get('taContent');

            if(!empty($request->file('fCoverImage'))){
                $photo = $request->file('fCoverImage');
                $extension = $photo->getClientOriginalExtension();
                $tmp_path = $photo->getPathName();
                
                $folder = 'images/cover/';
                $file_name = time() . "." . $extension;
                $new_path = public_path($folder).$file_name;

                try {
                    // insert cover image
                    File::move($tmp_path, $new_path);

                    $cover = new Images();
                    $coverId = $cover->insert(1, 'Cover image', 'images/cover/'.$file_name);

                    $updateData["idCoverImage"] = $coverId;
                }
                catch(\Illuminate\Database\QueryException $ex){
                    \Log::error($ex->getMessage());
                    return redirect()->back()->with('error','Greska pri dodavanju posta u bazu!');
                }
                catch(\Symfony\Component\HttpFoundation\File\Exception\FileException $ex) {
                    \Log::error('Problem sa fajlom!!'.$ex->getMessage());
                    return redirect()->back()->with('error','Greska pri dodavanju slike!');
                }
                catch(\ErrorException $ex) { 
                    \Log::error('Problem sa fajlom!!'.$ex->getMessage());
                    return redirect()->back()->with('error','Desila se greska..');
                }
            }

            // others can vote, locked
            $othersCanVote = $lock = 0;

            $othersCanVote = $request->has('chbOthers') ? 1 : 0;
            $lock = $request->has('chbLock') ? 1 : 0;

            $updateData["othersCanVote"] = $othersCanVote;
            $updateData["lockSubmissionAfterSubmitting"] = $lock;

            // update game jam
            $gameJamUpdate = $gameJams->update($idGameJam, $updateData);
            
            if(empty($gameJamUpdate))
            {
                return back()->withInput()->with('message', 'Game jam update failed!');
            }

            // update criteria
            $gameCriteriaGet = $request->get('chbCriteria');
            $gameCriteria = new GameCriteria();
            $selectedCriteria = [];

            if(!empty($gameCriteriaGet)){
                foreach($gameCriteriaGet as $val){
                    $selectedCriteria[] = (int)$val;
                }
            }

            $gameJamHasCriteriaDb = $gameJams->getCriteria($idGameJam);
            $deleteCriteria = [];
            $newCriteria = [];
            $gameJamHasCriteria = [];

            foreach($gameJamHasCriteriaDb as $e){
                $gameJamHasCriteria[] = $e->idGameCriteria;
            }

            // delete criteria
            foreach($gameJamHasCriteria as $idGameCriteria){
                if(!in_array($idGameCriteria, $selectedCriteria)){
                    $deleteCriteria[] = $idGameCriteria;
                }
            }

            foreach($deleteCriteria as $idGameCriteria){
                $gameJams->deleteCriteria($idGameJam, $idGameCriteria);
            }
            
            // add criteria
            foreach($selectedCriteria as $idGameCriteria){
                if(!in_array($idGameCriteria, $gameJamHasCriteria)){
                    $newCriteria[] = $idGameCriteria;
                }
            }

            foreach ($newCriteria as $idGameCriteria)
            {
                $gameJams->insertCriteria($idGameJam, $idGameCriteria);
            }

            return redirect("/game-jams/" . $idGameJam)->with('message', 'Game jam updated successfully!');
        }
    }

    public function delete($id) {
        $idUser = session()->get('user')[0]->idUser;
        $idGameJam = $id;

        $gameJams = new GameJams();

        if($gameJams->exist($idGameJam)) {
            if(!$gameJams->userOwnsGameJam($idUser, $idGameJam)){
                return Redirect::back()->withInput()->with('message', "You can't delete this game jam.");
            }
            else if($gameJams->getById($idGameJam)->startDate < time()){
                return Redirect::back()->withInput()->with('message', 'You can\'t delete an active game jam.');
            }
            else{
                $gameJams->update($idGameJam, ["isBlocked" => 1]);
                return Redirect::to('/')->withInput()->with('message', "Game jam deleted.");
            }
        }
        else {
            return Redirect::back()->withInput()->with('message', "Selected game jam doesn\'t exist :(");
        }
    }
}
