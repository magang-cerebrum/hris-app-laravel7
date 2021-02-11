<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionPaidLeave extends Model
{
    protected $fillable=[
        'user_id',
        'paid_leave_date_start',
        'paid_leave_date_end',
        'status',
        'paid_leave_type_id'
    ];
}
