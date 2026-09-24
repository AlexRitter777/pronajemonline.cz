<?php

namespace app\Support\Calculators;

use app\Enum\SettlementType;
use InvalidArgumentException;

final class CalculatorFactory
{

    public static function create(string $type) : Calculator
    {
        return match ($type) {
            SettlementType::SERVICES->value => new ServicesCalculator(),
            default => throw new InvalidArgumentException('Unknown calculator type'),
        };

    }

}