<?php
namespace Lib;

class HackableDatabase
{
    private static $db = null;

    /**
     * Insert/Update/Delete.
     *
     * @throws Lib\Exceptions\HackableException
     *
     * @param $sql The query
     */
    public static function update($sql)
    {
        Log::debug('HackableDatabase', sprintf('Update query: %s', $sql));

        $db = static::get_connection();

        $query = $db->query($sql);
        if (!$query) {
            throw new Exceptions\DatabaseException($sql);
        }
        return $query->lastInsertId();
    }

    /**
     * Select.
     *
     * @throws Lib\Exceptions\DatabaseException
     *
     * @param $sql The query
     *
     * @return Associative array of the result
     */
    public static function select($sql)
    {
        Log::debug('HackableDatabase', sprintf('Select query: %s', $sql));

        $db = static::get_connection();

        $query = $db->query($sql);
        if (!$query) {
            throw new Exceptions\DatabaseException($sql);
        }

        return $query->fetchAll();
    }

    public static function now()
    {
        return date('Y-m-d H:i:s', time());
    }

    /**
     * Create and return the connection to the database.
     *
     * @return PDO object
     */
    private static function get_connection()
    {
        if (is_null(self::$db)) {
            self::$db = new \PDO(sprintf('%s:host=%s;dbname=%s;charset=utf8',
                DB_TYPE, DB_HOST, DB_NAME), DB_USER, DB_PASS);
        }
        return self::$db;
    }
}
