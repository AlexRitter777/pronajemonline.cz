<?php

namespace app\DTO;

class AdminData
{
    public function __construct(
        public string $name,
        public ?string $phone,
        public ?string $email,
        public ?string $techName,
        public ?string $techPhone,
        public ?string $techEmail,
        public ?string $accName,
        public ?string $accPhone,
        public ?string $accEmail,
    ) {}
}
