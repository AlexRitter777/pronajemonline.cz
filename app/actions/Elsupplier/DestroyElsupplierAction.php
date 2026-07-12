<?php

namespace app\actions\Elsupplier;

use app\Exceptions\PersonNotFoundException;
use app\Models\Elsupplier;

final class DestroyElsupplierAction
{
    public function execute(Elsupplier $elsupplier, string $elsupplierId, string $userId): bool
    {
        if (!$elsupplier->deleteOneRecordByIdAndUserId($elsupplierId, $userId)) {
            throw new PersonNotFoundException('Dodavatel elektřiny nebyl nalezen.');
        }

        return true;
    }
}
