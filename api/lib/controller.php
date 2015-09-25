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

        Log::debug('Controller',
            sprintf('Begin request (method: "%s", content_type: "%s")', $method, $content_type));
        Log::debug('Controller',
            sprintf('Params: %s', var_export(Log::filter($params), true)));

        $this->request = new Request($method, $content_type, $params);
        $this->response = new Response();
        $this->session = new Session();

        try {
            $this->handleRequest();
        } catch (Exceptions\NotFoundException $e) {
            $this->response->set_header(Response::HTTP_NOT_FOUND);
        } catch (Exceptions\UnauthorizedException $e) {
            $this->response->set_header(Response::HTTP_UNAUTHORIZED);
        } catch (Exceptions\ValidateException $e) {
            $this->response->set_header(Response::HTTP_BAD_REQUEST);
        }

        $this->response->display();

        Log::debug('Controller', 'End request');
    }

    private function handleRequest()
    {
        Log::debug('Controller', 'Handle request');

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
