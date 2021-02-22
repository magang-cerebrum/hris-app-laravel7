<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionTicketing extends Model
{
    protected $fillable = ['user_id','category','status','message','response'];
    protected $nullable = ['user_id','response'];
}
