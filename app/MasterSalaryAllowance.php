<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterSalaryAllowance extends Model
{
    protected $fillable = ['information','type','nominal','month','year','user_id'];
    protected $nullable = ['month','year','user_id'];
}
