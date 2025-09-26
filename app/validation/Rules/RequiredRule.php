<?php

namespace app\validation\Rules;

use app\validation\Core\RuleInterface;

class RequiredRule implements RuleInterface
{

    public function validate(mixed $value): bool
    {
        return !empty($value);
    }

    public function getError(): string
    {
        return ':attribute je povinný údaj.';
    }
}