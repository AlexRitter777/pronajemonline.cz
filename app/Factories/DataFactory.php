<?php

namespace app\Factories;

abstract class DataFactory
{

    protected function normalizeData(array $data): array
    {
        foreach ($data as $key => $value) {
            if (is_string($value)) {
                $value = trim($value);
                $data[$key] = ($value === '') ? null : $value;
            }
        }

        // Special handling for checkbox inputs and arrays later

        return $data;
    }

}