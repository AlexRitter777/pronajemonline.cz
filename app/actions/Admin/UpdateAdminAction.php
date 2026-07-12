<?php

namespace app\actions\Admin;

use app\DTO\AdminData;
use app\Exceptions\PersonNotFoundException;
use app\Exceptions\RecordNotUpdatedException;
use app\Models\Admin;

final class UpdateAdminAction
{
    public function __construct(private Admin $admin)
    {
    }

    /**
     * @throws PersonNotFoundException
     * @throws RecordNotUpdatedException
     */
    public function execute(AdminData $data, string $adminId, string $userId): string
    {
        $updatedAdmin = $this->admin->getOneRecordById($adminId, $userId);

        if (!$updatedAdmin) {
            throw new PersonNotFoundException('Správce nebyl nalezen.');
        }

        $adminId = $this->admin->updateAll([
            'name' => $data->name,
            'phone' => $data->phone,
            'email' => $data->email,
            'tech_name' => $data->techName,
            'tech_phone' => $data->techPhone,
            'tech_email' => $data->techEmail,
            'acc_name' => $data->accName,
            'acc_phone' => $data->accPhone,
            'acc_email' => $data->accEmail,
            'updated_at' => date('Y-m-d H:i:s'),
        ], $updatedAdmin);

        if (!$adminId) {
            throw new RecordNotUpdatedException();
        }

        return $adminId;
    }
}
