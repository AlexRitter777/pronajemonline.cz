<?php

namespace app\actions\Landlord;

use app\db_models\Landlord;
use app\DTO\LandlordData;
use app\DTO\TenantData;
use app\services\Person\CreatePersonService;

class CreateLandlordAction
{
    public function __construct(private Landlord $landlord, private CreatePersonService $createPersonService)
    {
    }

    public function execute(LandlordData $data, string $userId): string
    {
        return $this->createPersonService->create($data, $this->landlord, $userId);
    }

}