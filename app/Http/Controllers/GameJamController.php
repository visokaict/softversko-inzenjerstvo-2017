<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Models\GameJams;
use App\Http\Models\GameCriteria;
use App\Http\Models\Images;
use Illuminate\Support\Facades\Validator;

class GameJamController extends Controller
{
    public function insert(Request $request){
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
            'tbTitle' => 'required|alpha_num',
            'taDescription' => 'required'
        ]);

        $validation->setAttributeNames([
            'tbTitle' => 'title',
            'taDescription' => 'description'
        ]);

        if($validation->fails()){
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
                if($request->has('chbOthers')){
                    $othersCanVote = 1;
                }
                if($request->has('chbLock')){
                    $lock = 1;
                }

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

                return redirect('/game-jams/create')->with('messages', 'Successfully created Game jam!');
            }
            catch(\Illuminate\Database\QueryException $ex){
                \Log::error($ex->getMessage());
                return redirect()->back()->with('error','Greska pri dodavanju posta u bazu!');
            }
            catch(\Symfony\Component\HttpFoundation\File\Exception\FileException $ex) {
                \Log::error('Problem sa fajlom!! '.$ex->getMessage());
                return redirect()->back()->with('error','Greska pri dodavanju slike!');
            }
            catch(\ErrorException $ex) { 
                \Log::error('Problem sa fajlom!! '.$ex->getMessage());
                return redirect()->back()->with('error','Desila se greska..');
            }
        }
    }
}
