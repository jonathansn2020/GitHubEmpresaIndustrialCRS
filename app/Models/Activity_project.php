<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity_project extends Model
{

    protected $fillable = ['operator_id'];

    use HasFactory;

    //relacion uno a muchos
    public function reworks(){

        return $this->hasMany('App\Models\Rework');

    }

    //relacion uno a muchos inversa
    public function operator(){

        return $this->belongsTo('App\Models\Operator');

    }
}
