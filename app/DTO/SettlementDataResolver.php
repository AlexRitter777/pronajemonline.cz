<?php

declare(strict_types=1);

namespace app\DTO;

use app\DTO\Contracts\SettlementData;
use app\Enums\SettlementType;

final readonly class SettlementDataResolver
{

    public function fromDatabase(SettlementType $type, array $row) : SettlementData
    {
        return $this->resolveClass($type)::fromDatabase($row);
    }

    public function formArray(SettlementType $type, array $row) : SettlementData
    {
        return $this->resolveClass($type)::fromArray($row);
    }


    /** @return class-string<SettlementData> */
    private function resolveClass(SettlementType $type) : string
    {
        $class = 'app\\DTO\\' . $type->data();

        if(!class_exists($class) || !is_subclass_of($class, SettlementData::class)){
            throw new \InvalidArgumentException("Unknown settlement DTO: {$type->data()}");
        }

        return $class;
    }
}