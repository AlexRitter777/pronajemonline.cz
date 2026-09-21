<?php

declare(strict_types=1);

namespace app\actions\Property;

use app\DTO\PropertyData;
use app\Exceptions\RecordNotCreatedException;
use app\Models\Property;

final class CreatePropertyAction
{
    public function execute(Property $property, PropertyData $data, int $userId): int
    {

        $propertyId = $property->saveAll([
            'address' => $data->address,
            'type' => $data->type,
            'add_info' => $data->addInfo,
            'rent_payment' => $data->rentPayment,
            'services_payment' => $data->servicesPayment,
            'electro_payment' => $data->electroPayment,
            'landlord_id' => $data->landlordId,
            'tenant_id' => $data->tenantId,
            'admin_id' => $data->adminId,
            'elsupplier_id' => $data->elsSupplierId,
            'contract_till' => $data->contractTill ? (new \DateTime($data->contractTill))->format('Y-m-d') : null,
            'user_id' => $userId
        ]);

        if(!$propertyId){
            throw new RecordNotCreatedException();
        }

        return $propertyId;

    }

}