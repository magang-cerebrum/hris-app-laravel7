<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterCheckPresence extends Model
{
    protected $fillable = [
        'user_id','shift','working_time'
    ];
}
