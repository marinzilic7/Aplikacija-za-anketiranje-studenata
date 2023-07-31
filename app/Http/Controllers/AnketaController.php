<?php

namespace App\Http\Controllers;

use App\Models\Anketa;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
                'pitanje3' => 'required',
                'category_id' => 'required',
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
            return response()->json(['poruka' => 'Anketa je uspjesno dodana']);
        }else{
            return response()->json(['poruka' => 'Neuspjesno dodavanje ankete!']);
        }


    }

    public function getAnketa(){
        $anketa = Anketa::with('category')->get();



        return response()->json($anketa);
    }

    public function deleteAnketa($id){
        try {
            $anketa = Anketa::findOrFail($id);
            $anketa->delete();

            return response()->json(['poruka' => 'Anketa je uspješno obrisana']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['poruka' => 'Anketa nije pronađena'], 404);
        }
    }

    public function urediAnketu (Request $request, $id){

        $anketa = Anketa::findOrFail($id);

        $data = $request->validate([
            'naziv' => 'required|string',
            'opis' => 'required|string',
            'pitanje1' => 'required|string',
            'pitanje2' => 'required|string',
            'pitanje3' => 'required|string',
        ]);

        $anketa->naziv=$data['naziv'];
        $anketa->opis=$data['opis'];
        $anketa->pitanje1=$data['pitanje1'];
        $anketa->pitanje2=$data['pitanje2'];
        $anketa->pitanje3=$data['pitanje3'];
        $anketa->save();

        return response()->json([
            'poruka' => 'Anketa uspjesno uređena',
            'anketa' => $anketa,
        ]);
    }



}
