<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['body', 'user_id', 'activity_project_id'];

    //relacion uno a muchos inverso
    public function activity()
    {

        return $this->belongsTo('App\Models\Activity');
    }

    public function user()
    {

        return $this->belongsTo('App\Models\User');
    }

    //relacion uno a muchos polimorfica
    public function resources(){

        return $this->morphMany('App\Models\Resource','resourceable');

    }
    
}
