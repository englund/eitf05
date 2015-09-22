<?php
define('_DS', DIRECTORY_SEPARATOR);

class AutoLoad
{
    /**
     * Register an autoload method.
     */
    public function __construct()
    {
        spl_autoload_register(array($this, 'load'));
    }

    /**
     * Autoload method.
     */
    public static function load($class)
    {
        $file = sprintf('%s%s%s.php', dirname(__file__), _DS,
            strtolower(str_replace('\\', _DS, $class)));
        if (file_exists($file)) {
            require $file;
        }
    }
}
