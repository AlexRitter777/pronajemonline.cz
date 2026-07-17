<?php

namespace app\controllers\Ajax;

use app\Models\Tenant;
use DI\Attribute\Inject;
use pronajem\base\Controller;

class TenantsController extends Controller
{
    #[Inject]
    private Tenant $tenant;

    public function getList(): array
    {
        $userId = $_SESSION['user_id'];
        $term = $_GET['term']['term'] ?? '';

        if ($term === '') {
            echo json_encode([]);
            exit();
        }

        $tenants = $this->tenant->getAllRecords(
            $term,
            ['name'],
            $userId
        );

        $result = [];

        foreach ($tenants as $tenant) {
            $result[] = [
                'id' => $tenant['id'],
                'text' => $tenant['name'],
            ];
        }

        echo json_encode($result);
        exit();
    }
}
