<?php

namespace spot\LaravelInstaller\Controller;

use Exception;
use Spot\LaravelInstaller\Support\EnvEditor;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;

class InstallDatabaseController extends Controller
{
    public function database()
    {
        if (
            in_array(false, (new InstallServerController())->check(), true) ||
            in_array(false, (new InstallFolderController())->check(), true)
        ) {
            return redirect()->route('LaravelInstaller::install.folders');
        }
        return view('Installer::install.database');
    }

    /**
     * Test database and set keys in .env
     *
     * @param  Request  $request
     * @return Application|Factory|RedirectResponse|View
     */
    public function setDatabase(Request $request)
    {
       
        try {
            
            //DB
            EnvEditor::setEnv('DB_CONNECTION', 'mysql');
            EnvEditor::setEnv('DB_HOST', $request->input('database_hostname'));
            EnvEditor::setEnv('DB_PORT', $request->input('database_port'));
            EnvEditor::setEnv('DB_DATABASE', $request->input('database_name'));
            EnvEditor::setEnv('DB_USERNAME', $request->input('database_username'));
            EnvEditor::setEnv('DB_PASSWORD', $request->input('database_password'));
            EnvEditor::setEnv('DB_PREFIX', $request->input('database_prefix'));

            //AUTH
            EnvEditor::setEnv('ADMIN_EMAIL', $request->input('adminemail'));
            EnvEditor::setEnv('ADMIN_PASSWORD', $request->input('adminpassword'));

            

            //Basics
            EnvEditor::setEnv('APP_NAME', $request->input('projectname'));
            EnvEditor::setEnv('APP_URL', $request->input('projecturl'));



            Artisan::call('config:clear');
            Artisan::call('cache:clear');
            Cache::flush();
            //DB::connection()->getPdo();
            
            return redirect()->route('LaravelInstaller::install.migrations');
        } catch (Exception $e) {
            return view('Installer::install.database', ['values' =>[], 'error' => $e->getMessage()]);
        }
    }

    /**
     * Success database connection
     *
     * @return Application|Factory|RedirectResponse|View
     */
    public function migrations()
    {
        if (
            !DB::connection()->getPdo() ||
            in_array(false, (new InstallServerController())->check(), true) ||
            in_array(false, (new InstallFolderController())->check(), true)
        ) {
            return redirect()->route('LaravelInstaller::install.database');
        }
        return view('Installer::install.migrations');
    }

    /**
     * Run laravel migrations & seeders
     *
     * @return Application|Factory|RedirectResponse|View
     */
    public function runMigrations()
    {
        if (
            !DB::connection()->getPdo() ||
            in_array(false, (new InstallServerController())->check(), true) ||
            in_array(false, (new InstallFolderController())->check(), true)
        ) {
            return redirect()->route('LaravelInstaller::install.database');
        }
        try {
            Artisan::call('migrate', ['--seed' => true]);
            return redirect()->route('LaravelInstaller::install.keys');
        } catch (Exception $e) {
            return view('Installer::install.migrations', ['error' => $e->getMessage() ?: 'An error occurred while executing migrations']);
        }
    }
}
