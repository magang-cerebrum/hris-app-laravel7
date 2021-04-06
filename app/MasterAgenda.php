<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterAgenda extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'title','description','start_event','end_event','calendar_color',
    ];
}
