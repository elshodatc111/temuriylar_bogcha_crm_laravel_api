<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingSms extends Model{

    protected $table = 'setting_sms';

    protected $fillable = [
        'login',
        'parol',
        'token',
        'token_data',
        'create_child_status',
        'create_child_text',
        'debet_send_status',
        'debet_send_text',
        'paymart_status',
        'paymart_text'
    ];
}
