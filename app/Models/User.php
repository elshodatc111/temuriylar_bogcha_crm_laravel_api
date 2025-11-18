<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'position_id',
        'name',
        'phone',
        'address',
        'tkun',
        'seriya',
        'type',
        'status',
        'password',
        'salary',
        'about',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'tkun'   => 'date',
        'status' => 'boolean',
    ];
    public function position(){return $this->belongsTo(Position::class);}
    public function rooms(){return $this->hasMany(Room::class, 'user_id');}
    public function deletedRooms(){return $this->hasMany(Room::class, 'delete_user_id');}
    public function children(){return $this->hasMany(Child::class);}
    public function childRelatives(){return $this->hasMany(ChildRelative::class);}
    public function childDocuments(){return $this->hasMany(ChildDocument::class);}
    public function childPaymarts(){return $this->hasMany(ChildPaymart::class);}


}
