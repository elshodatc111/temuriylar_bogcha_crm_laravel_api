<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BalansHistory extends Model{

    use HasFactory;

    protected $table = 'balans_histories';

    protected $fillable = [
        'type',
        'status',
        'amount',
        'about',
        'user_id',
        'admin_id',
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

}
