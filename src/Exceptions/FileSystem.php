<?php

namespace Communication\Exceptions;

class FileSystem extends BaseException
{
    public function __construct($error)
    {
        parent::__construct('File system error ' . $error);
    }
}
