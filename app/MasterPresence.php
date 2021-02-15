<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterPresence extends Model
{
    protected $fillable = ['user_id','in_time','out_time','inaday_time','late_time','late_time_rounded','presence_date'];
    protected $nullable = ['in_time','out_time','inaday_time','late_time','late_time_rounded'];
}
