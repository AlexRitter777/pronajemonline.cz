<?php

namespace app\actions\Elsupplier;

use app\DTO\ElsupplierData;
use app\Exceptions\PersonNotFoundException;
use app\Exceptions\RecordNotUpdatedException;
use app\Models\Elsupplier;

final class UpdateElsupplierAction
{
    public function __construct(private Elsupplier $elsupplier)
    {
    }

    /**
     * @throws PersonNotFoundException
     * @throws RecordNotUpdatedException
     */
    public function execute(ElsupplierData $data, string $elsupplierId, string $userId): string
    {
        $updatedElsupplier = $this->elsupplier->getOneRecordById($elsupplierId, $userId);

        if (!$updatedElsupplier) {
            throw new PersonNotFoundException('Dodavatel elektřiny nebyl nalezen.');
        }

        $elsupplierId = $this->elsupplier->updateAll([
            'name' => $data->name,
            'add_info' => $data->addInfo,
            'updated_at' => date('Y-m-d H:i:s'),
        ], $updatedElsupplier);

        if (!$elsupplierId) {
            throw new RecordNotUpdatedException();
        }

        return $elsupplierId;
    }
}
