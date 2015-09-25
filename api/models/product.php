<?php
namespace Models;

use \Lib\Database;

class Product extends \Lib\Model
{
    public $id;
    public $name;
    public $price;
    public $quantity;
    public $created;

    public function __construct($name, $price, $quantity,
        $id = null, $image_url, $created = null)
    {
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->id = $id;
        $this->image_url = $image_url;
        $this->created = $created;
    }

    public static function retrieve($id = null)
    {
        $params = array();
        $sql = 'SELECT id, name, price, quantity, image_url, created FROM products';
        if (!is_null($id)) {
            $sql .= ' WHERE id=:id';
            $params['id'] = $id;
        }
        $result = Database::select($sql, $params);
        $products = array();
        foreach ($result as $r) {
            $products[] = new Product(
                $r['name'],
                $r['price'],
                $r['quantity'],
                $r['id'],
                $r['image_url'],
                $r['created']
            );
        }

        if (!is_null($id)) {
            if (empty($products)) {
                throw new \Lib\Exceptions\NotFoundException();
            }
            return $products[0];
        }
        return $products;
    }

    public static function create($name, $price, $quantity, $image_url)
    {
        $sql =
            'INSERT INTO products '.
            '(name, price, quantity, image_url) '.
            'VALUES (:name, :price, :quantity, :image_url)';
        $params = array(
            'name' => $name,
            'price' => $price,
            'quantity' => $quantity,
            'image_url' => $image_url,
        );

        $id = Database::update($sql, $params);
        return new Product($name, $price, $quantity, $id, $image_url, Database::now());
    }


    public static function decrease_quantity($id, $quantity)
    {
        $sql = 'UPDATE products SET quantity=quantity - :quantity WHERE id=:id';
        $params = array(
            'id' => $id,
            'quantity' => $quantity,
        );
        return Database::update($sql, $params);
    }
}
