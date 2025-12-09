<?php

namespace App\Providers;

use App\Models\Servicio;
use App\Models\User;
use App\Policies\ServicioPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected array $policies = [
        Servicio::class => ServicioPolicy::class,
        User::class => UserPolicy::class,
    ];

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
        Vite::prefetch(concurrency: 3);

        // Force HTTPS scheme in production to avoid mixed-content with assets
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        // Register policies
        foreach ($this->policies as $model => $policy) {
            Gate::policy($model, $policy);
        }

        // Register gate for admin access
        Gate::define('admin', function (User $user) {
            return $user->hasRole('admin');
        });

        // Register gate for creating services
        Gate::define('create-servicio', function (User $user) {
            return $user->hasAnyRole(['admin', 'tecnico']);
        });
    }
}
