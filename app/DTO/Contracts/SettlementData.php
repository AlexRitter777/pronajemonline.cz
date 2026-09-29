<?php

namespace app\DTO\Contracts;

interface SettlementData
{

    public static function fromArray(array $data): self;
    public static function fromDatabase(array $data): self;
    public function toArray(): array;

}