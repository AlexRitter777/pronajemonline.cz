<?php

namespace app\validation\Rules;

use app\validation\Core\RuleInterface;

class CharRule implements RuleInterface

{
    private string $pattern = '/^[a-zA-Zá-žÁ-Ž0-9 .,\-]+$/u';

    private RegexRule $regex;
    public function validate(mixed $value): bool
    {
        $this->regex = new RegexRule($this->pattern);
        return  $this->regex->validate($value);
    }

    public function getError(): string
    {
        return $this->regex->getError();
    }

}