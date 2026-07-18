<?php

namespace app\controllers\Ajax;

use app\Models\Admin;
use DI\Attribute\Inject;
use pronajem\base\Controller;

class AdminsController extends Controller
{
    #[Inject]
    private Admin $admin;

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


}
