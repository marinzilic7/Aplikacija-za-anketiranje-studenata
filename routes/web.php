<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;



Route::post('/regUser',[UserController::class,'regUser']);

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '^(?!api).*$');
