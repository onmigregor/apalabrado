<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Palabra extends Model
{

    protected $fillable = [
        'palabra',
        'sin_acentos',
        'sencible',
    ];
}
