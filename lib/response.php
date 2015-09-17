<?php
namespace Lib;

class Response
{
    private $container = array();

    public function set($key, $value)
    {
        $this->container[$key] = $value;
    }

    public function toJSON()
    {
        return json_encode($this->container);
    }
}
