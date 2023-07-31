<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function dodajOdgovor(Request $request)
    {

        $data = $request->validate(
            [
                'odgovor' => 'required',
                'anketa_id' => '',
            ],

        );

        $data['user_id'] = auth()->id();

        $existingAnswer = Answer::where('user_id', $data['user_id'])
        ->where('anketa_id', $data['anketa_id'])
        ->first();

        if ($existingAnswer) {
            // Ako korisnik već glasa, onemogućite unos
            return response()->json(['poruka' => 'Već ste glasali za ovu anketu.']);
        }else{
            $odgovor = new Answer();
            $odgovor->create($data);
            return response()->json(['poruka' => 'Glasano']);
        }







    }
}
