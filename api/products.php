<?php
require_once 'app.php';

use Lib\Validate;
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
            $id = Validate::uint($args['id']);
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

        $name = Validate::plaintext($args['name']);
        $price = Validate::udouble($args['price']);
        $quantity = Validate::uint($args['quantity']);
        $image_url = Validate::image_url($args['image_url']);

        $product = Product::create($name, $price, $quantity, $image_url);
        $this->response->set_header(Lib\Response::HTTP_CREATED);
        $this->response->set('product', $product);
    }
}

$controller = new Products();
