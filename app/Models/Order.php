<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'requested', 'phone', 'email', 'delivery_place', 'order_business', 'expected_date', 'end_date', 'note', 'cod_document', 'status'];
    
    const REGISTRADA  = 1;
    const EN_PROCESO  = 2;
    const COMPLETADA  = 3;

    //relacion uno a muchos
    public function projects(){

        return $this->hasMany('App\Models\Project');

    }

    //relacion uno a muchos inversa
    public function User(){

        return $this->belongsTo('App\Models\User');

    }


    public function getCodigoCorrelativo(){        

        $codigo = DB::select("SELECT CONCAT('ORF', LPAD(MAX(SUBSTRING(cod_document, 4))+1, 12, '0')) AS codigo FROM orders");

        return $codigo;

    }


}
