<?php
require_once 'app.php';

class Users extends Lib\Controller
{
    public function index()
    {
        $users = User::retrieve();
        $this->response->set('users', $users);
    }

    public function create()
    {
        $args = $this->request->args;
        // TODO: validate and shit
        $username = $args['username'];
        $password = $args['password'];
        $address = $args['address'];
        $user = User::create($username, $password, $address);
        $this->response->set('user', $user);
    }
}

$controller = new Users();
$controller->response->display();
