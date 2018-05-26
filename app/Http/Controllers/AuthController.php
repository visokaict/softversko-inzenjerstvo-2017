<?php

namespace App\Http\Controllers;

use \App\Http\Interfaces\IAuthorization;
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
            'tbUsername' => 'required',
            'tbEmail' => 'required',
            'tbPassword' => 'required',
            'tbConfirmPassword' => 'required',
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
