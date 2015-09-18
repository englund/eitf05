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
