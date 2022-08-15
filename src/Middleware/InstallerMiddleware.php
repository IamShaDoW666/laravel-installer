<?php

namespace spot\LaravelInstaller\Middleware;

use Closure;
use Illuminate\Http\Request;

class InstallerMiddleware 
{
    public function handle(Request $request, Closure $next)
    {
        if ($this->alreadyInstalled() || explode('/', $request->route() ? $request->route()->uri() : '')[0] !== 'install') {
            abort(404);
        }

        return $next($request);
    }

    public function alreadyInstalled(): bool
    {
        return file_exists(storage_path('installed'));
    }

}