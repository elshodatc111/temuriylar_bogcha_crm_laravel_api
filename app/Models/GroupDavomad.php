<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GroupDavomad extends Model{
    use HasFactory;
    protected $fillable = [
        'group_id',
        'child_id',
        'data',
        'status',
        'user_id',
    ];
    protected $casts = [
        'data' => 'date:Y-m-d',
    ];
    public function group(){
        return $this->belongsTo(Group::class);
    }
    public function child(){
        return $this->belongsTo(Child::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
