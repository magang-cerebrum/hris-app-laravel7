<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterRecruitment extends Model
{
    protected $fillable=[
        'name',
        'dob',
        'live_at',
        'phone_number',
        'email',
        'gender',
        'last_education',
        'position',
        'file_cv',
        'file_portofolio'
    ];
}
