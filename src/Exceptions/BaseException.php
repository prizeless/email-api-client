<?php
namespace Communication\Exceptions;

class BaseException extends \Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
