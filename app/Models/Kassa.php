<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kassa extends Model{

    protected $table = 'kassas';

    protected $fillable = [
        'kassa_naqt',
        'kassa_card',
        'kassa_shot',
        'kassa_pedding_naqt',
        'kassa_pedding_card',
        'kassa_pedding_shot',
        'teacher_pedding_pay_naqt',
        'xarajat_pedding_naqt'
    ];

}
