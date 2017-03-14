<?php
namespace Communication\Utilities;

class Response
{
    public $status;

    public $message;

    public function __construct($status, $message)
    {
        $this->status = $status;

        $this->message = $message;
    }
}
