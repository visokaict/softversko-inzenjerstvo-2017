<?php

namespace App\Http\Controllers;

use \App\Http\Interfaces\IAuthorization;
use App\Http\Models\Roles;
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

        if ($validation->fails()) {
            return back()->withInput()->withErrors($validation);
        }

        $user = new Users();

        $dbUser = $user->getByUsernameOrEmailAndPassword($request->get('tbUsernameEmail'), $request->get('tbPassword'));

        if (!empty($dbUser)) {
            $userRoles = $user->getAllRoles($dbUser->idUser);

            $request->session()->push("user", $dbUser);
            $request->session()->push("roles", $userRoles);

            $isAdmin = Roles::arrayOfRolesHasRoleByName($userRoles, 'admin');

            if ($isAdmin) {
                return redirect('/admin');
            }

            //default redirect
            return redirect('/');
        }

        return back()->withInput()->withErrors(['message'=>"Username/Email or password is incorrect"]);
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
            strtolower($request->get('tbEmail')),
            strtolower($request->get('tbUsername')),
            $request->get('tbPassword')
        );

        //something went wrong and user isn't inserted
        if (empty($userId)) {
            return back()->withInput()->with('messages', 'Registration failed!');
        }


        //add roles
        if (!empty($userRoles)) {
            foreach ($userRoles as $role) {
                $user->addRole($role, $userId);
            }
        }

        return redirect('/login')->with('messages', 'You are successfully registered!');
    }
}
