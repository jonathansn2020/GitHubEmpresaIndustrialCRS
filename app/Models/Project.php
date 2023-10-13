<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'summary', 'long', 'width', 'thickness', 'rows', 'tube', 'progress', 'start_date_p', 'expected_date_p', 'end_date_p', 'url_photo', 'status', 'order_id'];
    const POR_PLANIFICAR  = 1;
    const EN_PROCESO      = 2;
    const FINALIZADO      = 3;

    //relacion uno a muchos inversa
    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

    //relacion muchos a muchos
    public function activities()
    {
        return $this->belongsToMany('App\Models\Activity')
                    ->withPivot('id','operator_id','priority', 'start_date', 'expected_date', 'true_start', 'end_date', 'position', 'status')
                    ->withTimestamps();;
    }
}
