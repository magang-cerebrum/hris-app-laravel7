<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterAchievement extends Model

{
    public $timestamps = false;    
    protected $fillable = [
        
        'score',
        'month',
        'year',
        'achievement_user_id'
    ];
}
