<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use App\Auth\UtilisateurTokenGuard;
use App\Auth\UserTokenGuard;
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
        Auth::extend('utilisateur_token', function ($app, $name, array $config) {
            return new UtilisateurTokenGuard(
                Auth::createUserProvider($config['provider']),
                $app['request']
            );
        });
    }
}
