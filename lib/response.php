<?php
namespace Lib;

class Response
{
    const HTTP_OK = 200;
    const HTTP_CREATED = 201;
    const HTTP_NO_CONTENT = 204;
    const HTTP_BAD_REQUEST = 400;
    const HTTP_UNAUTHORIZED = 401;
    const HTTP_NOT_FOUND = 404;
    const HTTP_CONFLICT = 409;

    private $container = array();

    public function __construct()
    {
        $this->set_header(self::HTTP_OK);
    }

    public function set($key, $value)
    {
        $this->container[$key] = $value;
    }

    public function display()
    {
        header('Content-Type: application/json');
        echo $this->get_json();
    }

    public function get_json()
    {
        return json_encode($this->container);
    }

    public function set_header($http_status_code)
    {
        http_response_code($http_status_code);
    }
}
