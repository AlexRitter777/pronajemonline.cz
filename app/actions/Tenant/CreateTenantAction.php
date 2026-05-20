<?php

namespace app\actions\Tenant;

use app\Models\Tenant;
use app\DTO\TenantData;
use app\services\Person\CreatePersonService;

class CreateTenantAction
{

    public function __construct(private Tenant $tenant, private CreatePersonService $createPersonService)
    {
    }
    public function execute(TenantData $data, string $userId): string
    {
        return $this->createPersonService->create($data, $this->tenant, $userId);
    }

}
