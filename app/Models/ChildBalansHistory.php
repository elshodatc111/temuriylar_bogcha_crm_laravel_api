<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChildBalansHistory extends Model{
    use HasFactory;
    protected $table = 'child_balans_histories';
    protected $fillable = [
        'child_id',
        'group_id',
        'amount',
        'about',
    ];
    public function child(){
        return $this->belongsTo(Child::class);
    }
    public function group(){
        return $this->belongsTo(Group::class);
    }
}
