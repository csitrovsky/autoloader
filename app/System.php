<?php

namespace app;


use function spl_autoload_register;

class System extends Autoload
{

    /**
     * @param bool $prepend
     *
     * @return void
     */
    public static function register(bool $prepend = false): void
    {
        spl_autoload_register(static function ($namespace) {
            self::include_system_file($namespace);
        }, true, $prepend);
    }
}