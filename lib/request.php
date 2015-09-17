<?php
namespace Lib;

class Request
{
    public $action;

    public function __construct($params)
    {
        $this->action = $params['action'];
    }
}
