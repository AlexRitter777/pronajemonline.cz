<?php

namespace app\Factories;

use app\DTO\AdminData;

class AdminDataFactory extends DataFactory
{
    public function createFromArray(array $data): AdminData
    {
        $data = $this->normalizeData($data);

        return new AdminData(
            name: $data['admin_name'],
            phone: $data['admin_phone'] ?? null,
            email: $data['admin_email'] ?? null,
            techName: $data['admin_tech_name'] ?? null,
            techPhone: $data['admin_tech_phone'] ?? null,
            techEmail: $data['admin_tech_email'] ?? null,
            accName: $data['admin_acc_name'] ?? null,
            accPhone: $data['admin_acc_phone'] ?? null,
            accEmail: $data['admin_acc_email'] ?? null,
        );
    }
}
