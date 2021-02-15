<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterJobSchedule extends Model
{
    protected $fillable=[
        'month',
        'year',
        'user_id',
        for ($x = 1; $x < 32 ; $x++) {
            'shift_id_day_'.$x,
        }
        'total'
    ];
}
