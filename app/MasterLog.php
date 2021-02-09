<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterLog extends Model
{
    //

    protected $fillable = ['user_id','activity','recorded_at'];
}
