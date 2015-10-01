<?php
namespace Models;

use \Lib\Log;
use \Lib\HackableDatabase;
use \Lib\Security;

class HackableUser extends User
{
    public static function authenticate($username, $password)
    {
        Log::info('HackableUser', sprintf('Authenticate user: "%s"', $username));

        try {
            $user = self::retrieve($username);
        } catch (\Lib\Exceptions\NotFoundException $e) {
            Log::info('User', sprintf('User not found: "%s"', $username));

            throw new \Lib\Exceptions\UnauthorizedException();
        }
        Log::debug('HackableUser', sprintf('User: "%s", salt: "%s"', $user->username, $user->salt));

        $hashed_password = static::generate_hash($password, $user->salt);
        if ($user->password !== $hashed_password) {
            Log::info('User', sprintf('Password does not match for user: "%s"', $username));

            throw new \Lib\Exceptions\UnauthorizedException();
        }

        $user->create_token();

        return $user;
    }

    public static function retrieve($username = null, $token = null)
    {
        $sql =
            'SELECT username, address, password, salt, is_admin, '.
            'token, token_expiration '.
            'FROM users';
        if (!is_null($username)) {
            $sql .= sprintf(' WHERE username="%s"', $username);
        } else if (!is_null($token)) {
            $sql .= sprintf(' WHERE token="%s" AND token_expiration>="%s"', $token, Database::now());
        }
        $result = HackableDatabase::select($sql);
        $users = array();
        foreach ($result as $r) {
            $is_admin = ($r['is_admin'] === '1') ? true : false;
            $users[] = new HackableUser(
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

    public static function exist($username)
    {
        $sql = sprintf('SELECT 1 FROM users WHERE username="%s"', $username);
        $result = HackableDatabase::select($sql);
        return (count($result) > 0);
    }

    public static function create($username, $password, $address)
    {
        if (static::exist($username)) {
            throw new \Lib\Exceptions\DuplicateException;
        }

        $salt = Security::generate_salt();
        $hashed_password = static::generate_hash($password, $salt);

        $sql =
            'INSERT INTO users '.
            '(username, password, salt, address) '.
            sprintf('VALUES("%s", "%s", "%s", "%s")', $username, $hashed_password, $salt, $address);
        $params = array(
            'username' => $username,
            'password' => $hashed_password,
            'salt' => $salt,
            'address' => $address,
        );

        HackableDatabase::update($sql);
        return new HackableUser($username, $address);
    }
}
