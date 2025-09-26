<?php

namespace app\validation\Rules;

use app\validation\Core\RuleInterface;

class EmailRule implements RuleInterface
{
    private string $pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
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