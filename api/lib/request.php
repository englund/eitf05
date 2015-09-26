<?php
namespace Lib;

class Request
{
    public $content_type;
    public $action;
    public $args;
    public $username;
    public $password;

    public function __construct($method, $content_type, $params)
    {
        $this->method = $method;
        $this->content_type = $content_type;

        if (isset($params['action'])) {
            $this->action = $params['action'];
            unset($params['action']);
        }
        $this->args = array_merge($params, $this->get_request_data());

        if (isset($_SERVER['PHP_AUTH_USER'])) {
            $this->username = $_SERVER['PHP_AUTH_USER'];
            $this->password = $_SERVER['PHP_AUTH_PW'];
        }

        Log::debug('Request',
            sprintf('Data: %s', var_export(Log::filter($this->args), true)));
    }

    /**
     * Get the request data like POST parameters.
     *
     * @return Array of the parameters
     */
    private function get_request_data()
    {
        $raw_request_data = file_get_contents('php://input');
        if ($this->content_type === 'application/json') {
            $output = json_decode($raw_request_data, true);
        } else {
            parse_str($raw_request_data, $output);
        }
        return empty($output) ? array() : $output;
    }
}
