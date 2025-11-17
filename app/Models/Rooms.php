<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rooms extends Model{
    use HasFactory;

    protected $fillable = [
        'name',
        'about',
        'size',
        'status',
        'user_id',
        'delete_user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function deletedBy(){
        return $this->belongsTo(User::class, 'delete_user_id');
    }

}
