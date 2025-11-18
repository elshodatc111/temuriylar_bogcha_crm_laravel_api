<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChildRelative extends Model{
    use HasFactory;
    protected $fillable = [
        'child_id',
        'name',
        'phone',
        'address',
        'about',
        'user_id',
    ];
    public function child(){
        return $this->belongsTo(Child::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function paymarts(){
        return $this->hasMany(ChildPaymart::class);
    }
}
