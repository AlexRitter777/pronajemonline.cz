<?php

namespace app\actions\Landlord;

use app\Exceptions\PersonNotFoundException;
use app\Models\Landlord;

final readonly class DestroyLandlordAction
{
    public function execute(Landlord $landlord, string $landlordId, string $userId): bool
    {
        if(!$landlord->deleteOneRecordByIdAndUserId($landlordId, $userId)){
            throw new PersonNotFoundException('Pronájímatel nebyl nalezen.');
        }
        return true;
    }
}