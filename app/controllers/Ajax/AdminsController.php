<?php

namespace app\controllers\Ajax;

use app\actions\Admin\CreateAdminAction;
use app\Factories\AdminDataFactory;
use app\Models\Admin;
use DI\Attribute\Inject;
use pronajem\base\Controller;

class AdminsController extends Controller
{
    #[Inject]
    private Admin $admin;

    #[Inject]
    private readonly AdminDataFactory $dataFactory;

    #[Inject]
    private readonly CreateAdminAction $action;

    public function getList(): never
    {
        $userId = $_SESSION['user_id'];
        $term = $_GET['term']['term'] ?? '';

        if ($term === '') {
            echo json_encode([]);
            exit();
        }

        $admins = $this->admin->getAllRecords(
            $term,
            ['name'],
            $userId
        );

        $result = [];

        foreach ($admins as $admin) {
            $result[] = [
                'id' => $admin['id'],
                'text' => $admin['name'],
            ];
        }

        echo json_encode($result);
        exit();
    }

    public function getOneRecord(int $adminId) : never
    {
        $userId = $_SESSION['user_id'];

        $admin = $this->admin->getOneRecordById($adminId, $userId);

        if (!$admin) {
            throw new \Exception('Record not found.', 404);
        }

        echo json_encode($admin);
        exit();

    }

    public function store() : never
    {
        $data = sanitize($_POST);
        $userId = $_SESSION['user_id'];
        $dto = $this->dataFactory->createFromArray($data);
        $adminId = $this->action->execute($dto, $userId);

        echo json_encode([
            'adminID' => $adminId,
            'adminName' => $dto->name,
        ]);
        exit();
    }


}
