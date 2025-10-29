<?php

namespace app\DTO;

class LandlordData
{
    public function __construct(
        public string $name,
        public string $address,
        public ?string $email,
        public ?string $phone,
        public ?string $account,
    ) {}

}