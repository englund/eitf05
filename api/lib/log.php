<?php
namespace Lib;

class Log
{
    /**
     * Detailed debug information.
     *
     * @param string $classname
     * @param string $message
     */
    public static function debug($classname, $message)
    {
        if (LOG_LEVEL <= 100) {
            $message = Log::format('DEBUG', $classname, $message);
            Log::write($message);
        }
    }

    /**
     * Interesting events.
     *
     * Example: user logs in, SQL logs.
     *
     * @param string $classname
     * @param string $message
     */
    public static function info($classname, $message)
    {
        if (LOG_LEVEL <= 200) {
            $message = Log::format('INFO', $classname, $message);
            Log::write($message);
        }
    }

    /**
     * Runtime errors that do not require immediate action but
     * should typically be logged and monitored.
     *
     * @param string $classname
     * @param string $message
     */
    public static function error($classname, $message)
    {
        if (LOG_LEVEL <= 400) {
            $message = Log::format('ERROR', $classname, $message);
            Log::write($message);
        }
    }

    public static function filter($params)
    {
        if (isset($params['password'])) {
            $params['password'] = '******';
        }
        return $params;
    }

    /**
     * Write message to a file.
     *
     * @param string $message
     */
    private static function write($message)
    {
        file_put_contents(LOG_PATH, $message, FILE_APPEND);
    }

    /**
     * Format all log messages in this way.
     *
     * @param string $type
     * @param string $classname
     * @param string $message
     */
    private static function format($type, $classname, $message)
    {
        $lines = explode("\n", $message);
        $formatted_message = '';
        foreach ($lines as $line) {
            $formatted_message .= sprintf("%s %s [%s] %s\n",
                        date('Y-m-d H:i:s'),
                        $type,
                        $classname,
                        $line);
        }
        return $formatted_message;
    }
}
