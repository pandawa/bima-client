<?php

declare(strict_types=1);

namespace Pandawa\Bima\Client;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Laravel\Horizon\Horizon;
use Pandawa\Bima\Client\Middleware\BimaAuthMiddleware;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
class BimaClientServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/bima.php', 'bima');
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/bima.php' => config_path('bima.php'),
            ], 'bima-config');
        }

        Horizon::auth(function() {
            return true;
        });

        /** @var Router $router */
        $router = $this->app['router'];

        $router->aliasMiddleware('bima.auth', BimaAuthMiddleware::class);
    }
}
