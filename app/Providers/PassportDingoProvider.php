<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Dingo\Api\Routing\Route;
use Illuminate\Http\Request;
use Dingo\Api\Auth\Provider\Authorization;

class PassportDingoProvider extends Authorization
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function authenticate(Request $request, Route $route)
    {
        return $request->user();
    }

    public function getAuthorizationMethod()
    {
        return 'bearer';
    }
}
