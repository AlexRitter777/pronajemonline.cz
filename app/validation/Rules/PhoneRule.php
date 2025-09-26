<?php

namespace app\validation\Rules;

use app\validation\Core\RuleInterface;

class PhoneRule implements RuleInterface
{
    private string $pattern = '~^\+?[0-9]{0,3}[ ]?[0-9]{3}[ ]?[0-9]{3}[ ]?[0-9]{3}$~';
    public function validate(mixed $value): bool
    {
        $regex = new RegexRule($this->pattern);
        return  $regex->validate($value);
    }

    public function getError(): string
    {
        return ':attribute není ve správném formátu.';
    }
}