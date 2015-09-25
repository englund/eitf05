<?php
require_once 'app.php';

use Lib\Validate;
use Models\Order;

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
        $user = $this->session->get_user();

        $args = $this->request->args;

        $username = $user->username;
        $total = Validate::udouble($args['total']);

        $order = Order::create($username, $total);
        $this->response->set_header(Lib\Response::HTTP_CREATED);
        $this->response->set('order', $order);
    }
}

$controller = new Orders();
