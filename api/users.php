<?php
require_once 'app.php';

use Lib\Validate;
use Models\User;

class Users extends Lib\Controller
{
    public function index()
    {
        $this->retrieve();
    }

    public function authenticate()
    {
        if (is_null($this->request->username) || is_null($this->request->password)) {
            throw new Lib\Exceptions\UnauthorizedException();
        }

        $username = Validate::plaintext($this->request->username);
        $password = Validate::password($this->request->password);

        $user = User::authenticate($username, $password);
        $this->response->set('user', $user);
    }

    public function remove_token()
    {
        $args = $this->request->args;
        $user = User::retrieve_by_token(Validate::token($args['token']));
        $user->remove_token();
    }

    public function create()
    {
        $args = $this->request->args;
        $username = Validate::plaintext($args['username']);
        $password = Validate::password($args['password']);
        $address = Validate::plaintext($args['address']);

        $user = User::create($username, $password, $address);
        $this->response->set_header(Lib\Response::HTTP_CREATED);
        $this->response->set('user', $user);
    }
}

$controller = new Users();
