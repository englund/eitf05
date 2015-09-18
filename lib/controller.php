<?php
namespace Lib;

use Lib\Request;
use Lib\Response;

class Controller
{
    protected $request;
    public $response;

    public function __construct()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $content_type = isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : '';
        $params = $_REQUEST;

        $this->request = new Request($method, $content_type, $params);
        $this->response = new Response();

        try {
            $this->handleRequest();
        } catch (Exceptions\NotFoundException $e) {
            // TODO: Do some cool stuff like displaying an error page or something!
        }
    }

    private function handleRequest()
    {
        $action = $this->request->action;
        if (empty($action)) {
            $this->index();
        } else {
            if (method_exists($this, $action)) {
                $this->{$action}();
            } else {
                throw new Exceptions\NotFoundException();
            }
        }
    }
}
