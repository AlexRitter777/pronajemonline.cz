<?php

namespace app\actions\Elsupplier;

use app\DTO\ElsupplierData;
use app\Exceptions\RecordNotCreatedException;
use app\Models\Elsupplier;

class CreateElsupplierAction
{
    public function __construct(private Elsupplier $elsupplier)
    {
    }

    /**
     * @throws RecordNotCreatedException
     */
    public function execute(ElsupplierData $data, string $userId): string
    {
        $elsupplierId = $this->elsupplier->saveAll([
            'name' => $data->name,
            'add_info' => $data->addInfo,
            'user_id' => $userId,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        if (!$elsupplierId) {
            throw new RecordNotCreatedException();
        }

        return $elsupplierId;
    }
}
