<?php

namespace app\Exceptions;

class RecordNotUpdatedException extends \DomainException
{

    public function __construct($message = "Record could not be updated.", $code = 500, \Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }

}