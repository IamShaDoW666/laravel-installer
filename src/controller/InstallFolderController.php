<?php

namespace spot\LaravelInstaller\Controller;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class InstallFolderController extends Controller
{

    public function index()
    {
        if (in_array(false, (new InstallServerController())->check(), true)) {
            return redirect()->route('LaravelInstaller::install.server');
        }
        return view('Installer::install.folders', ['checks' => $this->check()]);
    }

    public function check(): array
    {
        return [
            'storage.framework' => (int) File::chmod('../storage/framework') >= 775,
            'storage.logs' => (int) File::chmod('../storage/logs') >= 775,
            'bootstrap.cache' => (int) File::chmod('../bootstrap/cache') >= 775,
            'public.uploads' => (int) File::chmod('../public/imgs') >= 775,
        ];
    }
}
