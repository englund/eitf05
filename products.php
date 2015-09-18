<?php
require_once 'app.php';

use Models\Product;

class Products extends Lib\Controller
{
    public function index()
    {
        $products = Product::retrieve();
        $this->response->set('products', $products);
    }

    public function retrieve()
    {
        $args = $this->request->args;
        $id = isset($args['id']) ? $args['id'] : null;
        // TODO: validate and shit

        $product = Product::retrieve($id);
        $this->response->set('product', $product);
    }

    public function create()
    {
        $args = $this->request->args;

        $name = $args['name'];
        $price = $args['price'];
        $quantity = $args['quantity'];
        // TODO: validate and shit

        $product = Product::create($name, $price, $quantity);
        $this->response->set('product', $product);
    }
}

$controller = new Products();
$controller->response->display();
