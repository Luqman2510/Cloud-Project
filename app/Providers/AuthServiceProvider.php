<?php

namespace App\Providers;

use App\Models\User;
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
        // Define your model-to-policy mappings here if needed
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Define the is_admin gate
        Gate::define('is_admin', function (User $user) {
            return $user->is_admin; // Assumes your User model has the `is_admin` attribute
        });
    }
}
