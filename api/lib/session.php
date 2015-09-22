<?php
namespace Lib;

use Models\User;

class Session
{
    public function __construct()
    {
        session_start();

        Log::debug('Session', 'Start session');
    }

    public function set_user($user)
    {
        session_regenerate_id();
        $_SESSION['username'] = $user->username;
    }

    public function destroy()
    {
        $_SESSION = array();

        // remove cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(), '', time() - 42000,
                $params['path'], $params['domain'],
                $params['secure'], $params['httponly']
            );
        }

        session_destroy();

        Log::debug('Session', 'Destroy session');
    }

    public function get_user()
    {
        if (!$this->is_authenticated()) {
            throw new Exceptions\UnauthorizedException();
        }
        return User::retrieve($_SESSION['username']);
    }

    public function is_authenticated()
    {
        return isset($_SESSION['username']);
    }
}
