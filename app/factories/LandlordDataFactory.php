<?php

namespace app\factories;

use app\DTO\LandlordData;

class LandlordDataFactory extends DataFactory
{

    public function createFromArray(array $data) : LandlordData
    {
        $data = $this->normalizeData($data);

        return new LandlordData(
            name: $data['landlord_name'],
            address: $data['landlord_address'],
            email: $data['landlord_email'] ?? null,
            phone: $data['landlord_phone_number'] ?? null,
            account: $data['landlord_account'] ?? null,
        );
    }
}