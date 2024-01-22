<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    const REGISTRADA   = 'Registrada';
    const EN_PROCESO   = 'Proceso';
    const COMPLETADA   = 'Completada';

    protected $fillable = ['name','stage_id'];

    //relacion uno a muchos 
    public function comments(){

        return $this->hasMany('App\Models\Comment');
    }

    //relacion uno a muchos inverso
    public function stage(){

        return $this->belongsTo('App\Models\Stage');

    }

    public function user(){

        return $this->belongsTo('App\Models\User');

    }

    //relacion muchos a muchos
    public function projects(){

        return $this->belongsToMany('App\Models\Project')
                    ->withPivot('id','priority','operator_id','start_date','expected_date', 'true_start', 'end_date','position','status')
                    ->withTimestamps();

    }   
    
}
