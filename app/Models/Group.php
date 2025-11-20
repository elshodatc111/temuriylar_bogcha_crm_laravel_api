<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Group extends Model{
    use HasFactory;
    protected $fillable = [
        'name',
        'room_id',
        'price',
        'status',
        'user_id',
    ];
    protected $casts = ['status' => 'boolean',];

    public function room(){
        return $this->belongsTo(Room::class);
    }
    public function creator(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function tarbiyachilar(){
        return $this->hasMany(GroupTarbiyachi::class);
    }
    public function children(){
        return $this->hasMany(GroupChild::class);
    }
    public function davomads(){
        return $this->hasMany(GroupDavomad::class);
    }
    public function childBalansHistories(){
        return $this->hasMany(ChildBalansHistory::class);
    }
}
