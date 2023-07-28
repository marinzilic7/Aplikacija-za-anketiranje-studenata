<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use function Symfony\Component\String\b;

class UserController extends Controller
{
    public function regUser(Request $request)
    {

        $data = $request->validate(
            [
                'name' => 'required',
                'lastName' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:5|regex:/^[A-Z]/',
                'passwordConf' => 'required|same:password'
            ],
            [
                'name.required' => "Ime je obavezno",
                'lastName.required' => "Prezime je obavezno ",
                'email.required' => 'Email je obavezan',
                'email.email' => 'Unesite ispravan format email adrese.',
                'password.required' => 'Lozinka je obavezna',
                'password.min' => 'Lozinka mora imati minimalno 5 znakova ',
                'passwordConf.required' => 'Potvrda lozinke je obavezna',
                'passwordConf.same' => 'Vasa lozinka i potvrda vase lozinke nisu iste!',
                'password.regex' => 'Vasa lozinka mora zapoceti sa velikim pocetnim slovom'
            ]
        );

        $data['password'] = Hash::make($data['password']);
        $data['passwordConf'] = Hash::make($data['passwordConf']);
        $user = new User();
        $user->create($data);

        return response()->json(['poruka' => 'Uspjesna registracija']);
    }

    public function logUser(Request $request)
    {
        $data = $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required',

            ],
            [
                'email.email' => 'Unesite ispravan format email adrese.',
                'email.required' => 'Niste unijeli vas email',
                'password.required' => 'Niste unijeli vasu lozinku'
            ]
        );


        if (Auth::attempt($data)) {  /* provjerava da li korisnik postoji u bazi podataka */

            return response()->json(['poruka' => 'Uspješna prijava']);
        } else {

            return response()->json(['poruka' => 'Neuspješna prijava']);
        }
    }
}
