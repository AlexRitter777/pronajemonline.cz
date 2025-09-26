<?php

namespace app\validation\Core;

class RedirectOnFailValidator
{

    public function __construct(private Validator $validator, private ErrorBag $errorBag) {}

    public function validate(array $data): array
    {
        $errors = $this->validator->validate($data);


        if (!empty($errors)) {
            $this->errorBag->setErrors($errors, $data);
            redirect();
        }

        return $data;
    }


}