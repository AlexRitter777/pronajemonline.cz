<?php

namespace app\exceptions;

class PersonNotFoundException extends \RuntimeException
{

    public function __construct($message = "Person not found.", $code = 404, \Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }


}