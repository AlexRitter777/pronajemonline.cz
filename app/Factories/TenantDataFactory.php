<?php

namespace app\Factories;

use app\DTO\TenantData;

class TenantDataFactory extends DataFactory
{

    public function createFromArray(array $data): TenantData
    {

        $data = $this->normalizeData($data);
        return new TenantData(
            name: $data['tenant_name'],
            address: $data['tenant_address'],
            email: $data['tenant_email'] ?? null,
            phone: $data['tenant_phone_number'] ?? null,
            account: $data['tenant_account'] ?? null,
        );
    }

}