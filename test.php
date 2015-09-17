<?php
require_once 'app.php';

class Test extends Lib\Controller
{
    public function testA()
    {
        $this->response->set('test', 'hej');
    }
}

$test = new Test();
echo $test->response->toJSON();
