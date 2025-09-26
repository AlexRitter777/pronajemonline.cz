<?php

namespace app\DTO;

readonly class TenantData
{
    public function __construct(
        public string $name,
        public string $address,
        public ?string $email,
        public ?string $phone,
        public ?string $account,
    ) {}

}