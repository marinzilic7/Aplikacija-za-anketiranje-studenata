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

            return response()->json(['poruka' => 'Samo jednom mozete glasovati']);
        }else{
            $odgovor = new Answer();
            $odgovor->create($data);
            return response()->json(['poruka' => 'Uspjesno ste glasovali']);
        }







    }
}
