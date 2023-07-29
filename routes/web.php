<?php

use App\Http\Controllers\AnketaController;
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

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '^(?!api).*$');
