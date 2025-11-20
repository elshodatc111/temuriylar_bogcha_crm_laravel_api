<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserDavomad extends Model{

    use HasFactory;
    protected $table = 'user_davomads';
    protected $fillable = [
        'user_id',
        'status',
        'data',
        'admin_id',
    ];

    protected $casts = [
        'data' => 'date:Y-m-d',
    ];
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function admin(){
        return $this->belongsTo(User::class, 'admin_id');
    }
}
