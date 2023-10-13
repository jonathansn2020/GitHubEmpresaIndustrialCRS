<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    //relacion uno a muchos
    public function activities(){

        return $this->hasMany('App\Models\Activity');

    }
}
