<?php

namespace app\actions\Admin;

use app\Exceptions\PersonNotFoundException;
use app\Models\Admin;

final class DestroyAdminAction
{
    public function execute(Admin $admin, string $adminId, string $userId): bool
    {
        if (!$admin->deleteOneRecordByIdAndUserId($adminId, $userId)) {
            throw new PersonNotFoundException('Správce nebyl nalezen.');
        }

        return true;
    }
}
