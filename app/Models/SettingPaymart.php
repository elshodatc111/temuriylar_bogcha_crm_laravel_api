<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingPaymart extends Model{

    protected $table = 'setting_paymarts';

    protected $fillable = [
        'exson_foiz',
        'bonus_80_plus',
        'bonus_85_plus',
        'bonus_90_plus',
        'bonus_95_plus'
    ];
}
