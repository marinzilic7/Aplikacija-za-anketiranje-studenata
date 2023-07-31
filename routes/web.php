<?php

use App\Http\Controllers\AnketaController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/* Registracija i prijava */

Route::post('/regUser',[UserController::class,'regUser']);
Route::post('/logUser',[UserController::class,'logUser']);
Route::get('/isLogged',[UserController::class,'isLogged']);
Route::post('/logout',[UserController::class,'logout']);

/* Anketa */

Route::post('/dodajAnketu',[AnketaController::class,'dodajAnketu']);
Route::get('/getAnketa',[AnketaController::class,'getAnketa']);
Route::post('/delete/{id}',[AnketaController::class,'deleteAnketa']);
Route::post('/urediAnketu/{id}',[AnketaController::class,'urediAnketu']);


/* Predmeti */

Route::get('/getPredmeti',[CategoryController::class,'getPredmeti']);

/* Odgovor */

Route::post('/dodajOdgovor',[AnswerController::class,'dodajOdgovor']);

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '^(?!api).*$');
