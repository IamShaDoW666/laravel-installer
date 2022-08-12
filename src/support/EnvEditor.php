<?php

namespace spot\LaravelInstaller\Support;

use SetEnv;

class EnvEditor
{
    public static function setEnv($key, $value = null): void
    {
        SetEnv::setKey($key, $value);
        SetEnv::save();
    }

    public static function getEnv($key) 
    {
        SetEnv::getenv($key);
    }
}
