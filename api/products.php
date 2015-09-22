<?php
require_once 'app.php';

use Models\Product;

class Products extends Lib\Controller
{
    public function index()
    {
        $this->retrieve();
    }

    public function retrieve()
    {
        $args = $this->request->args;

        if (isset($args['id'])) {
            $id = $args['id']; // TODO: validate
            $product = Product::retrieve($id);
            $this->response->set('product', $product);
        } else {
            $products = Product::retrieve();
            $this->response->set('products', $products);
        }
    }

    public function create()
    {
        $user = $this->session->get_user();
        if (!$user->is_admin()) {
            throw new Lib\Exceptions\UnauthorizedException();
        }

        $args = $this->request->args;

        $name = $args['name'];
        $price = $args['price'];
        $quantity = $args['quantity'];
        // TODO: validate and shit

        $product = Product::create($name, $price, $quantity);
        $this->response->set_header(Lib\Response::HTTP_CREATED);
        $this->response->set('product', $product);
    }
}

$controller = new Products();
