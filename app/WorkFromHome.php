<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkFromHome extends Model
{
    protected $fillable=[
        'user_id',
        'wfh_date_start',
        'wfh_date_end',
        'days',
        'status',
        'needs',
        'informations'
    ];
}
