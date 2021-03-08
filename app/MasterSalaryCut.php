<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterSalaryCut extends Model
{
    protected $fillable = ['information','type','nominal','month','year','user_id'];
    protected $nullable = ['month','year','user_id'];
}
