<?php

namespace spot\LaravelInstaller;

use App\Http\Kernel;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use spot\LaravelInstaller\Middleware\InstallerMiddleware;
use spot\LaravelInstaller\Middleware\NotInstalledMiddleware;

class LaravelInstallerProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/installer.php', 'installer');
        $this->loadRoutesFrom(__DIR__ . '/Routes/web.php');
    }

    public function boot(Kernel $kernel, Router $router)
    {
        $kernel->prependMiddlewareToGroup('web', NotInstalledMiddleware::class);
        $router->pushMiddlewareToGroup('installer', InstallerMiddleware::class);
        $this->loadViewsFrom(__DIR__ . '/Views', 'Installer');
    }
}
