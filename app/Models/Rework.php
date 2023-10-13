<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rework extends Model
{
    use HasFactory;

    protected $fillable = ['start_date','hour','start','start_hour','end','end_hour','activity_project_id']; 
   
}
