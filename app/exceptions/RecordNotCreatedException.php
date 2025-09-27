<?php

namespace app\exceptions;

class RecordNotCreatedException extends \RuntimeException
{
    public function __construct($message = "Record could not be created.", $code = 500, \Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }

}