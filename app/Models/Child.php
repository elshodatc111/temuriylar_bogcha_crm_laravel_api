<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Child extends Model{
    use HasFactory;
    protected $table = 'children';
    protected $fillable = [
        'name',
        'seria',
        'tkun',
        'status',
        'balans',
        'balans_data',
        'guvohnoma',
        'passport',
        'gepatet',
        'user_id',
    ];
    protected $casts = [
        'tkun'         => 'date',
        'balans_data'  => 'date',
        'status'       => 'boolean',
        'guvohnoma'    => 'boolean',
        'passport'     => 'boolean',
        'gepatet'      => 'boolean',
    ];
    public function user(){return $this->belongsTo(User::class);}
    public function relatives(){return $this->hasMany(ChildRelative::class);}
    public function documents(){return $this->hasMany(ChildDocument::class);}
    public function paymarts(){return $this->hasMany(ChildPaymart::class);}
    public function groupChildren(){return $this->hasMany(GroupChild::class);}
    public function davomads(){return $this->hasMany(GroupDavomad::class);}
}
