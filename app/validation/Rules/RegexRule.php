<?php

namespace app\validation\Rules;

use app\validation\Core\RuleInterface;

class RegexRule implements RuleInterface
{

    public function __construct(private string $pattern, private string $message = '')
    {
    }
    public function validate(mixed $value): bool
    {
        if ($value === null || $value === '') {
            return true; // Consider empty values as valid
        }

        return preg_match($this->pattern, (string)$value) === 1;

    }

    public function getError(): string
    {
        return $this->message ?: ':attribute obsahuje nepovolené znaky.';
    }
}