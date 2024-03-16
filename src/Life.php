<?php

namespace Src;

use Src\Exposes\Admin;
use Src\RESTs\Settings;

class Life
{
    public static function activate(): void
    {
    }

    public static function deactivate(): void
    {
    }

    public static function register(): void
    {
        $services = [
            Admin::class,
            Settings::class,
        ];

        foreach ($services as $class) {
            new $class();
        }
    }
}
