<?php

namespace app\validation\Core;

class Validator
{

    private array $rules = [];
    private array $attributeNames = [];

    public function __construct(array $rules, array $attributeNames = [])
    {
        $this->rules = $rules;
        $this->attributeNames = $attributeNames;
    }

    public function validate($data) : array{

        $errors = [];

        foreach ($this->rules as $field => $fieldRules){

            $value = $data[$field] ?? null;

            foreach ($fieldRules as $rule){
                if(!$rule->validate($value)){
                    $label = $this->attributeNames[$field] ?? $field;
                    $errors[$field] = str_replace(':attribute', $label, $rule->getError());
                    break; // Stop at the first failed rule for this field
                }
            }

        }

        return $errors;
    }

}