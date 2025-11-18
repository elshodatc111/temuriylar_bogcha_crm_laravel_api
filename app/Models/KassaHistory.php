<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KassaHistory extends Model{
    use HasFactory;

    protected $table = 'kassa_histories';

    protected $fillable = [
        'type',
        'amount',
        'user_id',
        'admin_id',
        'teacher_id',
        'user_paymart_id',
        'create_data',
        'success_data',
        'status',
        'about',
    ];

    protected $casts = [
        'status' => 'boolean',
        'create_data' => 'datetime',
        'success_data' => 'datetime',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function admin(){
        return $this->belongsTo(User::class, 'admin_id');
    }
    public function teacher(){
        return $this->belongsTo(User::class, 'teacher_id');
    }
    public function userPaymart(){
        return $this->belongsTo(UserPaymart::class, 'user_paymart_id');
    }
}
