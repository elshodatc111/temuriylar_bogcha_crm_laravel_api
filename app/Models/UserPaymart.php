<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserPaymart extends Model{

    use HasFactory;

    protected $table = 'user_paymarts';

    protected $fillable = [
        'user_id',
        'admin_id',
        'status',
        'amount',
        'type',
        'about',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function admin(){
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function kassaHistories(){
        return $this->hasMany(KassaHistory::class, 'user_paymart_id');
    }

}
