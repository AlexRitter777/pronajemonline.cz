<?php

namespace app\actions\Tenant;

use app\Models\Tenant;
use app\DTO\TenantData;
use app\Exceptions\PersonNotFoundException;
use app\services\Person\UpdatePersonService;

class UpdateTenantAction
{

    public function __construct(private Tenant $tenant, private UpdatePersonService $updatePersonService)
    {
    }

    public function execute(TenantData $data, string $tenantId, string $userId): string
    {
        $updatedTenant = $this->tenant->getOneRecordById($tenantId, $userId);

        if(!$updatedTenant){
            throw new PersonNotFoundException('Nájemník nebyl nalezen.');
        }

        return $this->updatePersonService->update($data, $updatedTenant, $this->tenant);

    }




}