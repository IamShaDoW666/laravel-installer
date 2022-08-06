<?php
namespace Spot\LaravelInstaller\Controller;

use App\Http\Controllers\Controller;

class InstallIndexController extends Controller 
{
    public function index()
    {
        return view('Installer::install.index');
    }
}