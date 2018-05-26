<?php

namespace App\Http\Controllers;

use App\Http\Models\Polls;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactUsController extends Controller
{
    
    public function index(Request $request)
    {

    }

    public function pollVote(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'idPollQuestion' => 'required',
            'pollAnswer' => 'required|numeric'
        ]);

        if($validation->fails()){
            return back()->withInput()->withErrors($validation);
        }

        $userId = $request->session()->get('user')[0]->idUser;
        $qustionId = $request->get('idPollQuestion');
        $answerId = $request->get('pollAnswer');

        $poll = new Polls();
        $firstTimeVoitng = $poll->pollVote($userId, $qustionId, $answerId);

        if(!$firstTimeVoitng)
        {
            return back()->with('message', 'Sorry but you have already voted.');
        }

        return back()->with('message', 'Thank you for voting!');
    }
}
