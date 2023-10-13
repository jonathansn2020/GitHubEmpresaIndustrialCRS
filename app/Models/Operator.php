<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    use HasFactory;

    protected $fillable = ['name','document','phone','email','position'];


    //relacion uno a muchos
    public function activity_projects(){

        return $this->hasMany('App\Models\Activity_project');

    }

}
