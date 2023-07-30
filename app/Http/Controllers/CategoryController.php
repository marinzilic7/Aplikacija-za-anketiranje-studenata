<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getPredmeti(){

        $predmet = Category::get();


        return response()->json($predmet);
    }
}
