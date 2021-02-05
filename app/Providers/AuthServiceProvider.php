<?php

namespace App\Providers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\User;
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
        Gate::define('is_admin',function(User $user){
            
             $admin = Auth::User()->role;    
            if($admin == 'Admin'){
                return $admin;  
            }
        });
        Gate::define('is_staff',function(User $user){
            $staff = Auth::User()->role;
            if($staff == 'Staff'){
                return $staff;  
            }
        });

        //
    }
}
