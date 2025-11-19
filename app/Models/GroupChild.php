<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GroupChild extends Model{
    use HasFactory;

    protected $fillable = [
        'child_id',
        'group_id',
        'status',
        'start_data',
        'start_user_id',
        'start_about',
        'end_data',
        'end_user_id',
        'end_about',
    ];

    protected $casts = [
        'status' => 'boolean',
        'start_data' => 'date:Y-m-d',
        'end_data' => 'date:Y-m-d',
    ];

    public function group(){
        return $this->belongsTo(Group::class);
    }
    public function child(){
        return $this->belongsTo(Child::class);
    }
    public function startUser(){
        return $this->belongsTo(User::class, 'start_user_id');
    }
    public function endUser(){
        return $this->belongsTo(User::class, 'end_user_id');
    }
}
