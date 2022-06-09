<?php


namespace app;


use function class_exists;
use function file_exists;
use function http_response_code;
use function spl_autoload_register;
use function spl_autoload_unregister;
use function str_replace;
use function trim;
use const DIRECTORY_SEPARATOR;

class Autoload
{

    /**
     * @var null
     */
    private static $method = null;

    /**
     * @var string
     */
    private static string $namespace;

    /**
     * @var array
     */
    private static array $namespace_mapping = [];

    /**
     * @var string
     */
    private static string $file_location;

    /**
     * @return System|null
     */
    public static function run(): ?System
    {
        if (self::$method !== null) {
            return self::$method;
        }
        spl_autoload_register($autoload_function = [
            __CLASS__,
            'include_system_file',
        ], true, false);
        self::$method = $method = new System();
        spl_autoload_unregister($autoload_function);
        $method::register(true);
        return $method;
    }

    /**
     * @param string $namespace
     *
     * @return void
     */
    public static function include_system_file(string $namespace): void
    {
        if ((self::$namespace = $namespace) !== null) {
            self::set_namespace_mapping($namespace);
            self::attach_a_file();
        }
    }

    /**
     * @param string $namespace
     *
     * @return void
     */
    private static function set_namespace_mapping(string $namespace): void
    {
        self::$namespace_mapping[] = $namespace;
    }

    /**
     * @return void
     */
    private static function attach_a_file(): void
    {
        if (self::check_file_exists()) {
            require self::$file_location . '.php';
            self::check_class_exists();
        }
    }

    /**
     * @return bool
     */
    private static function check_file_exists(): bool
    {
        self::$file_location = self::converter_filename();
        return file_exists(self::$file_location . '.php');
    }

    /**
     * @return string
     */
    private static function converter_filename(): string
    {
        return INC_ROOT . '/' . trim(str_replace(
                '\\', DIRECTORY_SEPARATOR, self::$namespace
            ), '/');
    }

    /**
     * @return void
     */
    private static function check_class_exists(): void
    {
        if (class_exists(self::$namespace, $autoload = true)) {
            return;
        }
        self::error_output($code = 500, $message = '');
    }

    /**
     * @param int    $code
     * @param string $message
     *
     * @return void
     */
    private static function error_output(int $code, string $message = ''): void
    {
        http_response_code($response_code = $code);
        die('<pre>system@error % [' . $response_code . '] ~@ ' . $message . '...</pre>');
    }

    /**
     * @return array
     */
    public static function get_namespace_mapping(): array
    {
        return self::$namespace_mapping;
    }

}