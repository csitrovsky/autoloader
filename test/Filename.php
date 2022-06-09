<?php


namespace test;


use app\src\Error;

class Filename
{

    /**
     * @return void
     */
    public static function engine(): void
    {
        Error::output(200, 'The autoloader is working properly');
    }
}