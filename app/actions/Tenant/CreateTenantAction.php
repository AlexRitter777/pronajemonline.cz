<?php

namespace app\actions\Tenant;

use app\db_models\Tenant;
use app\DTO\TenantData;
use app\services\Person\CreatePersonService;

class CreateTenantAction
{

    public function __construct(private Tenant $tenant)
    {
    }
    public function execute(TenantData $data, string $userId): string
    {
        $service = new CreatePersonService($this->tenant);
        return $service->create($data, $userId);
    }

}
