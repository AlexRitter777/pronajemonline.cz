<?php

namespace app\exceptions;

class RecordNotUpdatedException extends \RuntimeException
{

    public function __construct($message = "Record could not be updated.", $code = 500, \Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }

}