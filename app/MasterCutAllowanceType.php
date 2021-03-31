<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterCutAllowanceType extends Model
{
    public $timestamps = false;
    protected $fillable = ['name','type','category'];
}
