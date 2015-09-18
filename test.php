<?php
require_once 'app.php';

class Test extends Lib\Controller
{
    public function index()
    {
        $this->response->set('test', 'index');
    }

    public function testA()
    {
        $this->response->set('test', 'testA');
    }
}

$test = new Test();
$test->response->display();
