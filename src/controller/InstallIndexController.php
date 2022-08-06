<?php

namespace Spot\LaravelInstaller\Controller;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class InstallIndexController extends Controller
{
    public function index()
    {
        return view('Installer::install.index');
    }

    public function finish()
    {
        if (
            empty(env('APP_KEY')) ||
            !DB::connection()->getPdo() ||
            in_array(false, (new InstallServerController())->check(), true) ||
            in_array(false, (new InstallFolderController())->check(), true)
        ) {
            return redirect()->route('LaravelInstaller::install.database');
        }
        $path = (string) url('/');
        $data = json_encode([
            'date' => date('Y/m/d h:i:s')
        ], JSON_THROW_ON_ERROR);
        file_put_contents(storage_path('installed'), $data, FILE_APPEND | LOCK_EX);
        Artisan::call('route:clear');
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('optimize:clear');
        return view('installer::steps.finish', ['path' => $path]);
    }
}
