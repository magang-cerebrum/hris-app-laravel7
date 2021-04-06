<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    protected $fillable = [
        'month',
        'year',
        'user_id',
        'hour',
        'payment'
    ];
}
