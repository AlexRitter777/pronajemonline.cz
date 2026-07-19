<?php

namespace app\controllers\Ajax;

use app\validator_ajax\ValidationRules;
use app\validator_ajax\Validator;

class ValidatorController
{
    public function validate(string $form) : never
    {

        if (empty($form)) {
            throw new \Exception('Form name is empty!', 500);
        }

        $data = $_POST;
        $validationRules = ValidationRules::getValidationRules($form);
        $validate = new Validator($data, $validationRules);
        $validationResult = $validate->validate();
        echo json_encode($validationResult);

        exit();

    }
}