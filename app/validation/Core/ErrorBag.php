<?php

namespace app\validation\Core;

class ErrorBag
{

    public function setErrors(array $errors, array $data) : void
    {
        $_SESSION['validator']['errors'] = $errors;
        $_SESSION['validator']['old'] = $data;
    }

    public function getErrors() : array {
        $data = [];
        $data['errors'] = $_SESSION['validator']['errors'] ?? [];
        $data['old'] = $_SESSION['validator']['old'] ?? [];

        $this->clear();

        return [
            $data['errors'],
            $data['old']
        ];
    }


    public function clear() : void
    {
        unset($_SESSION['validator']['errors'], $_SESSION['validator']['old']);
    }


}