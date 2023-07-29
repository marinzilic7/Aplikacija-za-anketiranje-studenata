<?php

namespace App\Http\Controllers;

use App\Models\Anketa;
use Illuminate\Http\Request;


class AnketaController extends Controller
{
    public function dodajAnketu(Request $request)
    {

        $data = $request->validate(
            [
                'naziv' => 'required',
                'opis' => 'required',
                'pitanje1' => 'required',
                'pitanje2' => 'required',
                'pitanje3' => 'required'
            ],
            [
                'naziv.required' => "Ime ankete je obavezno",
                'opis.required' => "Opis ankete je obavezan",



            ]
        );
        $anketa = new Anketa();
        $data['user_id'] = auth()->id();
        $anketa->create($data);
        if($anketa){
            return response()->json(['poruka' => 'Anketa dodana']);
        }else{
            return response()->json(['poruka' => 'Neuspjesno dodavanje ankete!']);
        }


    }

    public function getAnketa(){

        $anketa = Anketa::get();


        return response()->json($anketa);
    }

}
