<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterJobSchedule extends Model
{
    protected $fillable=[
        'month',
        'year',
        'date',
        'user_id',
        'shift_id'
    ];
}
