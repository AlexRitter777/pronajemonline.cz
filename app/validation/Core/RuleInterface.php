<?php

namespace app\validation\Core;

interface RuleInterface
{
    public function validate(mixed $value) : bool;


    public function getError() : string;

}