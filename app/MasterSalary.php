<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterSalary extends Model
{   
    protected $fillable=[
        'user_id',
        'month',
        'year',
        'total_default_hour',
        'total_work_time',
        'total_late_time',
        'total_fine',
        'default_salary',
        'total_salary_cut',
        'total_salary_allowance',
        'total_salary',
        'file_salary',
        'status'
    ];
}
