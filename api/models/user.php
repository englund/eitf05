<?php
namespace Models;

use \Lib\Log;
use \Lib\Database;
use \Lib\Security;

class User extends \Lib\Model
{
    public $username;
    public $address;

    private $password;
    private $salt;
    private $is_admin;

    public function __construct($username, $address, $password = null, $salt = null, $is_admin = 0)
    {
        $this->username = $username;
        $this->address = $address;
        $this->password = $password;
        $this->salt = $salt;
        $this->is_admin = $is_admin;
    }

    public function is_admin()
    {
        return $this->is_admin;
    }

    public static function authenticate($username, $password)
    {
        Log::info('User', sprintf('Authenticate user: "%s"', $username));

        try {
            $user = self::retrieve($username);
        } catch (\Lib\Exceptions\NotFoundException $e) {
            Log::info('User', sprintf('User not found: "%s"', $username));

            throw new \Lib\Exceptions\UnauthorizedException();
        }

        $hashed_password = self::generate_hash($password, $user->salt);
        if ($user->password !== $hashed_password) {
            Log::info('User', sprintf('Password does not match for user: "%s"', $username));

            throw new \Lib\Exceptions\UnauthorizedException();
        }
        return $user;
    }

    public static function retrieve($username = null)
    {
        $params = array();
        $sql = 'SELECT username, address, password, salt, is_admin FROM users';
        if (!is_null($username)) {
            $sql .= ' WHERE username=:username';
            $params['username'] = $username;
        }
        $result = Database::select($sql, $params);
        $users = array();
        foreach ($result as $r) {
            $is_admin = ($r['is_admin'] === '1') ? true : false;
            $users[] = new User(
                $r['username'],
                $r['address'],
                $r['password'],
                $r['salt'],
                $is_admin
            );
        }

        if (!is_null($username)) {
            if (empty($users)) {
                throw new \Lib\Exceptions\NotFoundException();
            }
            return $users[0];
        }
        return $users;
    }

    public static function create($username, $password, $address)
    {
        $salt = Security::generate_salt();
        $hashed_password = self::generate_hash($password, $salt);

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

    private static function generate_hash($password, $salt)
    {
        return Security::hash(sprintf('%s||%s', $password, $salt));
    }
}
