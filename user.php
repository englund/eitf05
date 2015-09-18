<?php

use Lib\Database;
use Lib\Security;

class User extends Lib\Model
{
    public $username;
    public $address;

    public function __construct($username, $address)
    {
        $this->username = $username;
        $this->address = $address;
    }

    public static function retrieve($username = null)
    {
        $params = array();
        $sql = 'SELECT username, address FROM users';
        if (!is_null($username)) {
            $sql .= ' WHERE username=:username';
            $params['username'] = $username;
        }

        $result = Database::select($sql, $params);
        $users = array();
        foreach ($result as $r) {
            $users[] = new User($r['username'], $r['address']);
        }
        return $users;
    }

    public static function create($username, $password, $address)
    {
        $salt = Security::generate_salt();
        $hashed_password = Security::hash(sprintf('%s||%s', $password, $salt));

        $sql =
            'INSERT INTO users '.
            '(username, password, salt, address) '.
            'VALUES(:username, :password, :salt, :address)';
        $params = array(
            'username' => $username,
            'password' => $hashed_password,
            'salt' => $salt,
            'address' => $address,
        );

        Database::update($sql, $params);
        return new User($username, $address);
    }
}
