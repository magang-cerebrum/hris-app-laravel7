<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class LogPresence extends Model
{
    public $timestamps = false;
    use Notifiable;
    protected $fillable = [
        'user_id','date','time'
    ];
    protected $nullable = [
        'user_id'
    ];
}
