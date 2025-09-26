<?php

namespace app\validation\Rules;

use app\validation\Core\RuleInterface;

class MinLengthRule implements RuleInterface
{

    public function __construct(private int $min)
    {
    }

    public function validate(mixed $value): bool
    {
        if ($value === null || $value === '') {
            return true; // Consider empty values as valid
        }

        $stringValue = (string) $value;

        return mb_strlen($stringValue) >= $this->min;
    }



    public function getError(): string
    {
        return ":attribute musí mít alespoň {$this->min} znaků.";
    }
}