<?php
namespace Lib\Exceptions;

class DatabaseException extends \Exception
{
    public $sql;

    public function __construct($sql, $message = null)
    {
        $this->sql = $sql;
        parent::__construct($message);
    }
}
