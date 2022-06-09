<?php


namespace app\src;


class Error
{

    /**
     * @param int    $code
     * @param string $message
     *
     * @return void
     */
    public static function output(int $code, string $message = ''): void
    {
        http_response_code($response_code = $code);
        die('<pre>system@error % [' . $response_code . '] ~@ ' . $message . '...</pre>');
    }
}