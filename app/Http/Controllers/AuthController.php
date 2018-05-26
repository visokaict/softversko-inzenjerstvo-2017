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
        $validation = Validator::make($request->all(), [
            'tbUsernameEmail' => 'required',
            'tbPassword' => 'required'
        ]);

        $validation->setAttributeNames([
            'tbUsernameEmail' => 'username',
            'tbPassword' => 'password'
        ]);

        if($validation->fails()){
            return back()->withInput()->withErrors($validation);
        } else {
            $user = new Users();
            $user->username = $request->get('tbUsernameEmail');

            $user->password = $request->get('tbPassword');

            $dbUser = $user->getByUsernameAndPassword();

            if(!empty($dbUser)){
                $request->session()->push("user", $dbUser);
                return redirect('/admin');
            } else {
                return redirect()->back();
            }
            
        }
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
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

        $userRoles = $request->get('userRoles');
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


        //add roles
        if(!empty($userRoles)) {
            foreach ($userRoles as $role)
            {
                $user->addRole($role, $userId);
            }
        }

        return redirect('/login')->with('messages', 'You are successfully registered!');
    }
}
