<?php
namespace Models;

use \Lib\Database;

class Order extends \Lib\Model
{
    public $id;
    public $username;
    public $total;
    public $created;

    public function __construct($username, $total,
        $id = null, $created = null)
    {
        $this->username = $username;
        $this->total = $total;
        $this->id = $id;
        $this->created = $created;
    }

    public static function retrieve($id = null)
    {
        $params = array();
        $sql = 'SELECT id, username, total, created FROM orders';
        if (!is_null($id)) {
            $sql .= ' WHERE id=:id';
            $params['id'] = $id;
        }
        $result = Database::select($sql, $params);
        $orders = array();
        foreach ($result as $r) {
            $orders[] = new Order(
                $r['username'],
                $r['total'],
                $r['id'],
                $r['created']
            );
        }

        if (!is_null($id)) {
            if (empty($orders)) {
                throw new \Lib\Exceptions\NotFoundException();
            }
            return $orders[0];
        }
        return $orders;
    }

    public static function create($username, $total)
    {
        $sql =
            'INSERT INTO orders '.
            '(username, total) '.
            'VALUES (:username, :total)';
        $params = array(
            'username' => $username,
            'total' => $total,
        );

        $id = Database::update($sql, $params);
        return new Order($username, $total, $id, Database::now());
    }
}
