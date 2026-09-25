<?php

declare(strict_types=1);

namespace app\DTO\Concerns;

trait CastsScalars
{
    protected static function toFloat(mixed $value, float $default = 0.0): float
    {
        if ($value === null || $value === '') {
            return $default;
        }
        if (is_string($value)) {
            $value = str_replace([' ', "\u{00A0}", ','], ['', '', '.'], $value);
        }
        return (float) $value;
    }

    protected static function toInt(mixed $value, int $default = 0): int
    {
        if ($value === null || $value === '') {
            return $default;
        }
        return (int) $value;
    }

    /** @return float[] */
    protected static function toFloatArray(array $values): array
    {
        return array_map(static fn($v) => self::toFloat($v), $values);
    }
}