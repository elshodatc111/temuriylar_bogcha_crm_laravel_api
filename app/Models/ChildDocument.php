<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChildDocument extends Model{

    use HasFactory;

    protected $fillable = [
        'child_id',
        'type',
        'url',
        'user_id',
    ];

    public function child(){
        return $this->belongsTo(Child::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
