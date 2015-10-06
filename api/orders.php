<?php
require_once 'app.php';

use Lib\Validate;
use Models\Order;
use Models\Product;
use Models\User;

class Orders extends Lib\Controller
{
    public function index()
    {
        $this->retrieve();
    }

    public function retrieve()
    {
        $args = $this->request->args;

        if (isset($args['id'])) {
            $id = Validate::uint($args['id']);
            $order = Order::retrieve($id);
            $this->response->set('order', $order);
        } else {
            $orders = Order::retrieve();
            $this->response->set('orders', $orders);
        }
    }

    public function create()
    {
        $args = $this->request->args;
        $user = User::retrieve_by_token(Validate::token($args['token']));

        $username = $user->username;
        $total = Validate::udouble($args['total']);
        $products = $args['products'];
        foreach ($products as $id => $quantity) {
            Product::decrease_quantity(Validate::uint($id), Validate::uint($quantity));
        }

        $order = Order::create($username, $total);
        $this->response->set_header(Lib\Response::HTTP_CREATED);
        $this->response->set('order', $order);
    }

    public function hackable_create()
    {
        $args = $this->request->args;
        $token = $_COOKIE['user_token'];
        $user = User::retrieve_by_token(Validate::token($token));

        $username = $user->username;
        $total = Validate::udouble($args['total']);
        $products = $args['products'];
        foreach ($products as $id => $quantity) {
            Product::decrease_quantity(Validate::uint($id), Validate::uint($quantity));
        }

        $order = Order::create($username, $total);
        $this->response->set_header(Lib\Response::HTTP_CREATED);
        $this->response->set('order', $order);
    }
}

$controller = new Orders();
