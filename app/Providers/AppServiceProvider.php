<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('data-entry', function (User $user) {
            return $user->admin === 1
            ? Response::allow()
            : Response::deny('You must be an administrator.');
        });

        Gate::define('is-admin', function (User $user) {
            return $user->admin === 'Admin'
            ? Response::allow()
            : Response::deny('You must be an administrator.');
        });
    }
}
