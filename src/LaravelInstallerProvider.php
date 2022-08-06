<?php

namespace Spot\LaravelInstaller;

use App\Http\Kernel;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Spot\LaravelInstaller\Middleware\InstallerMiddleware;
use Spot\LaravelInstaller\Middleware\NotInstalledMiddleware;

class LaravelInstallerProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/installer.php', 'installer');
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
    }

    public function boot(Kernel $kernel, Router $router)
    {
        $kernel->prependMiddlewareToGroup('web', NotInstalledMiddleware::class);
        $router->pushMiddlewareToGroup('installer', InstallerMiddleware::class);
        $this->loadViewsFrom(__DIR__ . '/views', 'Installer');
    }
}
