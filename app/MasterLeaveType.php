<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Factories\HasFactory;
class MasterLeaveType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // use HasFactory;
    protected $fillable = [
        'name',
        'default_day'
    ];
}
