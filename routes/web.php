<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;



Route::post('/regUser',[UserController::class,'regUser']);
Route::post('/logUser',[UserController::class,'logUser']);
Route::get('/isLogged',[UserController::class,'isLogged']);
Route::post('/logout',[UserController::class,'logout']);

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '^(?!api).*$');
