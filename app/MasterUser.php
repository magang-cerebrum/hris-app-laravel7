<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class MasterUser extends Authenticatable
{   
    use Notifiable;
    protected $fillable = [
        'nip','name','dob','address','phone_number','gender','email','password','profile_photo',
        'employee_status','employee_type','status,','contract_duration','start_work_date','end_work_date',
        'yearly_leave_remaining','division_id','position_id','role_id','shift_id','credit_card_number','salary',
        'identity_card_number', 'family_card_number', 'npwp_number', 'bpjs_healthcare_number', 'bpjs_employment_number'
    ];

    protected $nullable = [
        'address','profile_photo','contract_duration','end_work_date','division_id','position_id','shift_id',
        'family_card_number', 'npwp_number', 'bpjs_healthcare_number', 'bpjs_employment_number'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
}
