<?php

namespace app\actions\Tenant;

use app\db_models\Tenant;
use app\exceptions\PersonNotFoundException;

class DestroyTenantAction
{
    public function execute(Tenant $tenant, string $tenantId, string $userId): bool
    {
        if(!$tenant->deleteOneRecordByIdAndUserId($tenantId, $userId)){
            throw new PersonNotFoundException('Nájemník nebyl nalezen.');
        }
        return true;
    }

}