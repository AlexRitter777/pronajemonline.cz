<?php
namespace app\validation\Rules;

use app\validation\Core\RuleInterface;

class MaxLengthRule implements RuleInterface
{
    public function __construct(
        private int $max
    ) {}

    public function validate(mixed $value): bool
    {
        if ($value === null || $value === '') {
            return true; // Consider empty values as valid
        }

        $stringValue = (string) $value;

        return mb_strlen($stringValue) <= $this->max;
    }

    public function getError(): string
    {
        return ':attribute nesmí být delší než ' . $this->max . ' znaků.';
    }
}
