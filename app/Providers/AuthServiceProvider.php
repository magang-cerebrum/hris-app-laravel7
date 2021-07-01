<?php

namespace App\Providers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\MasterUser;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('is_admin',function(MasterUser $user){
            
            $admin = Auth::User()->role_id;    
            if($admin == 1){
                return $admin;  
            }
        });
        Gate::define('is_staff',function(MasterUser $user){
            $staff = Auth::User()->role_id;
            if($staff == 2){
                return $staff;  
            }
        });
        Gate::define('is_chief', function(MasterUser $user){
            $chief = Auth::User()->position_id;
            if($chief != 11 && $chief != 1 && $chief != 2){
                return $chief;
            }
        });
        //
    }
}
