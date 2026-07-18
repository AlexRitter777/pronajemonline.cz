<?php

namespace app\controllers\Ajax;

use app\Models\Tenant;
use DI\Attribute\Inject;
use pronajem\base\Controller;

class TenantsController extends Controller
{
    #[Inject]
    private Tenant $tenant;

    public function getList(): never
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

    public function getOneRecord(int $tenantId) : never
    {
        $userId = $_SESSION['user_id'];

        $tenant = $this->tenant->getOneRecordById($tenantId, $userId);

        if (!$tenant) {
            throw new \Exception('Record not found.', 404);
        }

        echo json_encode($tenant);
        exit();

    }

}
