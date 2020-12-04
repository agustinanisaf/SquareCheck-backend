<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function ($request) {
            return app('auth')->setRequest($request)->user();
        });

        // Gate Definition
        Gate::define('student', function ($user) {
            return $user->role === 'student';
        });

        Gate::define('lecturer', function ($user) {
            return $user->role === 'lecturer';
        });

        Gate::define('student-admin', function ($user) {
            return $user->role === 'student' || $user->role === 'admin';
        });

        Gate::define('lecturer-admin', function ($user) {
            return $user->role === 'lecturer' || $user->role === 'admin';
        });

        Gate::define('admin', function ($user) {
            return $user->role === 'admin';
        });
    }
}
