<?php

namespace app\controllers\Ajax;

use app\Models\Elsupplier;
use DI\Attribute\Inject;
use pronajem\base\Controller;

class ElsuppliersController extends Controller
{
    #[Inject]
    private Elsupplier $elsupplier;

    public function getElsuppliersList(): array
    {
        $userId = $_SESSION['user_id'];
        $term = $_GET['term']['term'] ?? '';

        if ($term === '') {
            echo json_encode([]);
            exit();
        }

        $elsuppliers = $this->elsupplier->getAllRecords(
            $term,
            ['name'],
            $userId
        );

        $result = [];

        foreach ($elsuppliers as $elsupplier) {
            $result[] = [
                'id' => $elsupplier['id'],
                'text' => $elsupplier['name'],
            ];
        }

        echo json_encode($result);
        exit();
    }
}
