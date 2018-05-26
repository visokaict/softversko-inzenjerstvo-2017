<?php

namespace App\Http\Controllers;

use \App\Http\Interfaces\IAuthorization;
use App\Http\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller implements IAuthorization
{
    public function login(Request $request)
    {
        //todo
        dd($request);
    }

    public function logout(Request $request)
    {
        //todo
        dd($request);
    }

    public function register(Request $request)
    {
        $validacija = Validator::make($request->all(), [
            'tbEmail' => 'required|unique:users,email',
            'tbUsername' => 'required|unique:users,username',
            'tbPassword' => 'required|confirmed|min:6',
        ]);
        $validacija->setAttributeNames([
            'tbEmail' => 'email',
            'tbUsername' => 'username',
            'tbPassword' => 'password',
        ]);

        if ($validacija->fails()) {
            // redirecija na pocetnu i ispis gresaka
            return back()->withInput()->withErrors($validacija);
        }

        $user = new Users();
        $userId = $user->insert(
            $request->get('tbEmail'),
            $request->get('tbUsername'),
            $request->get('tbPassword')
        );

        //something went wrong and user isn't inserted
        if(empty($userId))
        {
            return back()->withInput()->with('messages', 'Registration failed!');
        }

        return redirect('/login')->with('messages', 'You are successfully registered!');
    }
}
