<?php

namespace app\Factories;

use app\DTO\ElsupplierData;

class ElsupplierDataFactory extends DataFactory
{
    public function createFromArray(array $data): ElsupplierData
    {
        $data = $this->normalizeData($data);

        return new ElsupplierData(
            name: $data['elsupplier_name'],
            addInfo: $data['elsupplier_add_info'] ?? null,
        );
    }
}
