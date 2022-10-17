<?php

declare(strict_types=1);

namespace Pandawa\Bima\Client;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Pandawa\Bima\Client\Middleware\BimaAuthMiddleware;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
class BimaClientServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/bima.php', 'bima');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/bima.php' => config_path('bima.php'),
            ], 'bima-config');
        }

        /** @var Router $router */
        $router = $this->app['router'];

        $router->aliasMiddleware('bima.auth', BimaAuthMiddleware::class);
    }
}
