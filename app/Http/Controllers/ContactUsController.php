<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\IContactUs;
use App\Http\Models\Polls;
use App\Mail\ContactUsMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactUsController extends Controller implements IContactUs
{
    
    public function index(Request $request)
    {

    }

    public function pollVote(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'idPollQuestion' => 'required|numeric',
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

    public function postContact(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'tbFullName' => 'required',
            'tbEmail' => 'required',
            'soSubject' => 'required',
            'tbMessage' => 'required',
        ]);

        $validation->setAttributeNames([
            'tbFullName' => 'Full name',
            'tbEmail' => 'Email',
            'soSubject' => 'Subject',
            'tbMessage' => 'Message',
        ]);

        if($validation->fails()){
            return back()->withInput()->withErrors($validation);
        }

        $sendData = [
            'fullName' => $request->get('tbFullName'),
            'email' => $request->get('tbEmail'),
            'subject' => $request->get('soSubject'),
            'userMessage' => $request->get('tbMessage'),
        ];

        Mail::to('admins@slam-jam.com')->send(new ContactUsMail($sendData));
        return back()->with('message', 'Thank you for contacting us!');
    }
}
