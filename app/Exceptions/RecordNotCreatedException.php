<?php

namespace app\Exceptions;

class RecordNotCreatedException extends \DomainException
{
    public function __construct($message = "Record could not be created.", $code = 500, \Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }

}