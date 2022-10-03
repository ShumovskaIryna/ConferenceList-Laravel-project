<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /* define a ADMIN user role */
        Gate::define('isAdmin', function($user) {
            return $user->role == 'ADMIN';
        });

        /* define a ANNOUNCER user role */
        Gate::define('isAnnouncer', function($user) {
            return $user->role == 'ANNOUNCER';
        });

        /* define a LISTENER user role */
        Gate::define('isListener', function($user) {
            return $user->role == 'LISTENER';
        });
    }
}
