<?php

namespace Communication\Exceptions;

class Validation extends BaseException
{
    public function __construct($validationRule)
    {
        parent::__construct('Validation rule ' . $validationRule . ' failed.');
    }
}
