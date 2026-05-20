<?php

namespace app\Exceptions;

class PersonNotFoundException extends \DomainException
{

    public function __construct($message = "Person not found.", $code = 404, \Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }


}