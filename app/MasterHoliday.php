<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterHoliday extends Model
{
    protected $fillable=[
        'information',
        'date',
        'total_day'
    ];
}
