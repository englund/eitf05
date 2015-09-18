<?php
namespace Lib;

class Database
{
    private static $db = null;

    /**
     * Insert/Update/Delete.
     *
     * @throws Lib\Exceptions\DatabaseException
     *
     * @param $sql The query
     * @param $params Array of field => value parameters
     */
    public static function update($sql, $params)
    {
        $db = static::get_connection();

        $query = $db->prepare($sql);
        if (!$query->execute($params)) {
            throw new Exceptions\DatabaseException($sql);
        }
        return $db->lastInsertId();
    }

    /**
     * Select.
     *
     * @throws Lib\Exceptions\DatabaseException
     *
     * @param $sql The query
     * @param $params Array of field => value parameters
     *
     * @return Associative array of the result
     */
    public static function select($sql, $params = array())
    {
        $db = static::get_connection();

        $query = $db->prepare($sql);
        $query->setFetchMode(\PDO::FETCH_ASSOC);

        if (!($query->execute($params))) {
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
            self::$db = new \PDO(sprintf('%s:host=%s;dbname=%s;',
                DB_TYPE, DB_HOST, DB_NAME), DB_USER, DB_PASS);
        }
        return self::$db;
    }
}
