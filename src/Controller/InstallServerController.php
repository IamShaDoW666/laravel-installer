<?php

namespace spot\LaravelInstaller\Controller;

use App\Http\Controllers\Controller;


class InstallServerController extends Controller
{
    public function index()
    {
        return view('Installer::install.server', ['checks' => $this->check()]);
    }

    public function check(): array
    {
        return [
            'php' => version_compare(PHP_VERSION, config('installer.php'), '>'),
            'pdo' => defined('PDO::ATTR_DRIVER_NAME'),
            'mbstring' => extension_loaded('mbstring'),
            'fileinfo' => extension_loaded('fileinfo'),
            'openssl' => extension_loaded('openssl'),
            'tokenizer' => extension_loaded('tokenizer'),
            'json' => extension_loaded('json'),
            'curl' => extension_loaded('curl')
        ];
    }
}
