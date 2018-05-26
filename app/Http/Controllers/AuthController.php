<?php

namespace App\Http\Controllers;

use \App\Http\Interfaces\IAuthorization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \App\Http\Models\Users;

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
            return back()->withErrors($validation);
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
            'tbUsername' => 'required|unique:users,username',
            'tbEmail' => 'required|unique:users,email',
            'tbPassword' => 'required|confirmed|min:6',
        ]);

        if ($validacija->fails()) {
            // redirecija na pocetnu i ispis gresaka
            return back()->withErrors($validacija);
        }

        // provera u bazi

        /*
        $korisnik = new Korisnik();
        $korisnik->korisnicko_ime = $request->get('tbKorisnickoIme');

        $korisnik->lozinka = $request->get('tbLozinka');

        $dbUser = $korisnik->getByUsernameAndPassword();

        if (!empty($dbUser)) {
            // postoji korisnik u bazi
            $request->session()->push("korisnik", $dbUser);
            return redirect('/admin')->with('uspeh', "Uspesno ste se ulogovali!");
        } else {
            return redirect('/')->with('uspeh', 'Niste registrovani!');
        }
*/

    }
}
