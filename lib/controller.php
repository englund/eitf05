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
        $this->request = new Request($_REQUEST);
        $this->response = new Response();

        $this->handleRequest();
    }

    private function handleRequest()
    {
        $action = $this->request->action;
        // TODO: Do some checking if action exist!
        $this->$action();
    }
}
