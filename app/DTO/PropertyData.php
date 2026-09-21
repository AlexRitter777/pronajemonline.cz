<?php
declare(strict_types=1);

namespace app\DTO;

final readonly class PropertyData
{

    public function __construct(

        public string $address,
        public string $type,
        public ?string $addInfo,
        public ?int $rentPayment,
        public ?int $servicesPayment,
        public ?int $electroPayment,
        public ?int $landlordId,
        public ?int $tenantId,
        public ?int $adminId,
        public ?int $elsSupplierId,
        public ?string $contractTill,

    ){}

    public static function fromArray(array $data): self
    {
        $data = self::normalizeData($data);

        return new self(
            address: $data['property_address'],
            type: $data['property_type'],
            addInfo: $data['addInfo'] ?? null,
            rentPayment: $data['rentPayment'] ?? null,
            servicesPayment: $data['servicesPayment'] ?? null,
            electroPayment: $data['electroPayment'] ?? null,
            landlordId: $data['landlordId'] ?? null,
            tenantId: $data['tenantId'] ?? null,
            adminId: $data['adminId'] ?? null,
            elsSupplierId: $data['elsSupplierId'] ?? null,
            contractTill: $data['contractTill'] ?? null,
        );
    }


    protected static function normalizeData(array $data): array
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