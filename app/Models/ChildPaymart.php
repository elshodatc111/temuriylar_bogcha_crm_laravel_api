<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChildPaymart extends Model{

    use HasFactory;

    protected $fillable = [
        'child_id',
        'child_relative_id',
        'amount',
        'type',
        'about',
        'status',
        'user_id',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function child(){
        return $this->belongsTo(Child::class);
    }

    public function relative(){
        return $this->belongsTo(ChildRelative::class, 'child_relative_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
