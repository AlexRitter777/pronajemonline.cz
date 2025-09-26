<?php

namespace app\validation\Rules;

use app\validation\Core\RuleInterface;

class AccountRule implements RuleInterface
{

    private string $pattern = '~^(([0-9]{0,6})-)?([0-9]{1,10})/[0-9]{4}$~';
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