<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Balans extends Model{

    protected $table = 'balans';

    protected $fillable = [
        'naqt',
        'card',
        'shot',
        'exson_naqt',
        'exson_card',
        'exson_shot'
    ];
}
