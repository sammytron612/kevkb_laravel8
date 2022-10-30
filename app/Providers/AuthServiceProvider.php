<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Settings;

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

        /* define a admin user role */
        Gate::define('isAdmin', function($user) {
            return $user->role == 'admin';
         });

         Gate::define('isEditor', function($user) {
             return $user->role == 'editor';
          });


         Gate::define('isViewer', function($user) {
             return $user->role == 'viewer';
         });

         Gate::define('canDelete', function() {
            return Settings::find(1)->allow_delete;
        });

        Gate::define('stealth', function() {
            return Settings::find(1)->stealth;
        });

    }
}
