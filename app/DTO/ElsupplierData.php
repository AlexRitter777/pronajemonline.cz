<?php

namespace app\DTO;

class ElsupplierData
{
    public function __construct(
        public string $name,
        public ?string $addInfo,
    ) {}
}
