<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AcceptedWorkFromHome extends Model
{
    protected $fillable = [
        'wfh_id',
        'user_id',
        'date'
    ];
}
