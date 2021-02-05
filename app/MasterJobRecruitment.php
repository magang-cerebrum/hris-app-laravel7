<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterJobRecruitment extends Model
{
    protected $fillable=[
        'name',
        'descript',
        'required'
    ];
}
