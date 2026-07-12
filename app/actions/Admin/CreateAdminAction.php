<?php

namespace app\actions\Admin;

use app\DTO\AdminData;
use app\Exceptions\RecordNotCreatedException;
use app\Models\Admin;

class CreateAdminAction
{
    public function __construct(private Admin $admin)
    {
    }

    /**
     * @throws RecordNotCreatedException
     */
    public function execute(AdminData $data, string $userId): string
    {
        $adminId = $this->admin->saveAll([
            'name' => $data->name,
            'phone' => $data->phone,
            'email' => $data->email,
            'tech_name' => $data->techName,
            'tech_phone' => $data->techPhone,
            'tech_email' => $data->techEmail,
            'acc_name' => $data->accName,
            'acc_phone' => $data->accPhone,
            'acc_email' => $data->accEmail,
            'user_id' => $userId,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        if (!$adminId) {
            throw new RecordNotCreatedException();
        }

        return $adminId;
    }
}
