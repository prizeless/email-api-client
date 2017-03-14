<?php
namespace Communication\Exceptions;

class RequestException extends BaseException
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
