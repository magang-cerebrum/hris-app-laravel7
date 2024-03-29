<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterPresence extends Model
{
    protected $fillable = ['user_id','in_time','out_time','inaday_time','late_time','fine','presence_date','shift_name','shift_default_hour','status','file_in','file_out','check_chief'];
    protected $nullable = ['in_time','out_time','inaday_time','late_time','late_time_rounded','shift_name','shift_default_hour','file_in','file_out'];
}
