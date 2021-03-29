<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterShift extends Model
{
    protected $fillable = ['name','start_working_time','end_working_time','total_hour','calendar_color'];
}
