<?php

namespace Spot\LaravelInstaller\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class InstallKeysController extends Controller
{
    public function index()
    {
        if (
            !DB::connection()->getPdo() ||
            in_array(false, (new InstallServerController())->check(), true) ||
            in_array(false, (new InstallFolderController())->check(), true)
        ) {
            return redirect()->route('LaravelInstaller::install.database');
        }
        return view('Installer::install.keys');
    }

    public function setKeys()
    {
        if (
            !DB::connection()->getPdo() ||
            in_array(false, (new InstallServerController())->check(), true) ||
            in_array(false, (new InstallFolderController())->check(), true)
        ) {
            return redirect()->route('LaravelInstaller::install.database');
        }
        try {
            Artisan::call('key:generate', ['--force' => true, '--show' => true]);
            if (empty(env('APP_KEY'))) {
                EnvEditor::setEnv('APP_KEY', trim(str_replace('"', '', Artisan::output())));
            }
            Artisan::call('storage:link');
            if (empty(env('APP_KEY'))) {
                return view('Installer::install.keys', ['error' => 'The application keys could not be generated.']);
            }
            return redirect()->route('LaravelInstaller::install.finish');
        } catch (Exception $e) {
            return view('Installer::install.keys', ['error' => $e->getMessage()]);
        }
    }
}
