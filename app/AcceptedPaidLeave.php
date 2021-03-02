<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AcceptedPaidLeave extends Model
{  
    protected $fillable = [
        'paid_leave_id',
        'user_id',
        'date'
    ];
}
