<?php 
namespace spot\LaravelInstaller\Middleware;

use Closure;
use Illuminate\Http\Request;

class NotInstalledMiddleware 
{
    public function handle(Request $request, Closure $next)
    {
        if (!$this->alreadyInstalled() && explode('/', $request->route() ? $request->route()->uri() : '')[0] !== 'install') {
            return redirect()->route('LaravelInstaller::install.index');
        }

        return $next($request);
    }

    public function alreadyInstalled(): bool
    {
        return file_exists(storage_path('installed'));
    }
}