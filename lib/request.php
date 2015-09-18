<?php
namespace Lib;

class Request
{
    public $action;

    public function __construct($params)
    {
        $this->action = array_key_exists('action', $params) ? $params['action'] : '';
    }
}
