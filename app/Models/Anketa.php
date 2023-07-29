<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anketa extends Model
{
    protected $fillable = [
        'naziv', 'opis', 'pitanje1', 'pitanje2','pitanje3','user_id'
    ];
    use HasFactory;
}
