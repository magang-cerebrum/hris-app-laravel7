<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterOvertime extends Model
{
    protected $fillable = ['month','year','user_id','hour','payment','status'];
}
