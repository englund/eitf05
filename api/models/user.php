<?php
namespace Models;

use \Lib\Log;
use \Lib\Database;
use \Lib\Security;

class User extends \Lib\Model
{
    public $username;
    public $address;
    public $token;
    public $token_expiration;

    private $password;
    private $salt;
    private $is_admin;

    public function __construct(
        $username,
        $address,
        $password = null,
        $salt = null,
        $is_admin = 0,
        $token = null,
        $token_expiration = null)
    {
        $this->username = $username;
        $this->address = $address;
        $this->password = $password;
        $this->salt = $salt;
        $this->is_admin = $is_admin;
        $this->token = $token;
        $this->token_expiration = $token_expiration;
    }

    public function is_admin()
    {
        return $this->is_admin;
    }

    public function create_token()
    {
        $expiration = date('Y-m-d H:i:s', strtotime('+15 minutes'));
        $token = hash('sha256', sprintf('%s||%s||%s', $this->username, Security::generate_salt(), time()));
        try {
            $this->save_token($token, $expiration);
            $this->token = $token;
            $this->token_expiration = $expiration;
        } catch (\Lib\Exceptions\DatabaseException $e) {
            throw new \Lib\Exceptions\UnauthorizedException();
        }
    }

    public function save_token($token, $expiration)
    {
        $sql =
            'UPDATE users '.
            'SET token=:token, token_expiration=:expiration '.
            'WHERE username=:username';
        $params = array(
            'username' => $this->username,
            'token' => $token,
            'expiration' => $expiration,
        );
        Database::update($sql, $params);
    }

    public function remove_token()
    {
        $sql =
            'UPDATE users '.
            'SET token=:token, token_expiration=:expiration '.
            'WHERE username=:username';
        $params = array(
            'username' => $this->username,
            'token' => null,
            'expiration' => null,
        );
        Database::update($sql, $params);

        $this->token = null;
        $this->token_expiration = null;
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

        $user->create_token();

        return $user;
    }

    public static function retrieve_by_token($token)
    {
        return static::retrieve(null, $token);
    }

    public static function retrieve($username = null, $token = null)
    {
        $params = array();
        $sql =
            'SELECT username, address, password, salt, is_admin, '.
            'token, token_expiration '.
            'FROM users';
        if (!is_null($username)) {
            $sql .= ' WHERE username=:username';
            $params['username'] = $username;
        } else if (!is_null($token)) {
            $sql .= ' WHERE token=:token AND token_expiration>=:now';
            $params['token'] = $token;
            $params['now'] = Database::now();
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
                $is_admin,
                $r['token'],
                $r['token_expiration']
            );
        }

        if (!is_null($username)) {
            if (empty($users)) {
                throw new \Lib\Exceptions\NotFoundException();
            }
            return $users[0];
        }

        if (!is_null($token)) {
            if (empty($users)) {
                throw new \Lib\Exceptions\UnauthorizedException();
            }
            return $users[0];
        }

        return $users;
    }

    private static function exist($username)
    {
        $sql = 'SELECT 1 FROM users WHERE username=:username';
        $params = array('username' => $username);
        $result = Database::select($sql, $params);
        return (count($result) > 0);
    }

    public static function create($username, $password, $address)
    {
        if (static::exist($username)) {
            throw new \Lib\Exceptions\DuplicateException;
        }

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
