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
        $odgovor = new Answer();
        $data['user_id'] = auth()->id();
        $odgovor->create($data);
        if($odgovor){
            return response()->json(['poruka' => 'Glasano']);
        }else{
            return response()->json(['poruka' => 'Neuspjesno glasanje!']);
        }


    }
}
