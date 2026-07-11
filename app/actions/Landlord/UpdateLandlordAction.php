<?php

namespace app\actions\Landlord;

use app\DTO\LandlordData;
use app\Exceptions\PersonNotFoundException;
use app\Models\Landlord;
use app\services\Person\UpdatePersonService;

final class UpdateLandlordAction
{

    public function __construct(
        private Landlord $landlord,
        private UpdatePersonService $updatePersonService)
    {}

    public function execute(LandlordData $data, string $landlordId, string $userId): string
    {
        $updatedLandlord = $this->landlord->getOneRecordById($landlordId, $userId);

        if(!$updatedLandlord){
            throw new PersonNotFoundException('Pronájímatel nebyl nalezen.');
        }

        return $this->updatePersonService->update($data, $updatedLandlord, $this->landlord);

    }
}