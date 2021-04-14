<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterPerformance extends Model
{
    //
    public $timestamps = false;   
    protected $fillable = [
        'performance_score',
        'month',
        'year',
        'user_id',
        'division_id'
    ];
}
