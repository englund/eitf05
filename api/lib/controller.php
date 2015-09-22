<?php
namespace Lib;

use Lib\Request;
use Lib\Response;
use Lib\Session;

class Controller
{
    protected $request;
    protected $response;
    protected $session;

    public function __construct()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $content_type = isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : '';
        $params = $_REQUEST;

        $this->request = new Request($method, $content_type, $params);
        $this->response = new Response();
        $this->session = new Session();

        try {
            $this->handleRequest();
        } catch (Exceptions\NotFoundException $e) {
            $this->response->set_header(Response::HTTP_NOT_FOUND);
        } catch (Exceptions\UnauthorizedException $e) {
            $this->response->set_header(Response::HTTP_UNAUTHORIZED);
        }

        $this->response->display();
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
