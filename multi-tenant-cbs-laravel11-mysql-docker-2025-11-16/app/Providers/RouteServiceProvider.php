<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // register tenant middleware alias
        $router = $this->app['router'];
        $router->aliasMiddleware('tenant', \App\Http\Middleware\TenantResolver::class);
    }
}
