<?php

namespace app\controllers\Ajax;

use app\Models\Landlord;
use DI\Attribute\Inject;
use pronajem\base\Controller;

class LandlordsController extends Controller
{

    #[Inject]
    private Landlord $landlord;

    public function getList() : array
    {
        $userId = $_SESSION['user_id'];
        $term = $_GET['term']['term'] ?? '';

        if ($term === '') {
            echo json_encode([]);
            exit();
        }

        $landlords = $this->landlord->getAllRecords(
            $term,
            ['name'],
            $userId
        );

        $result = [];

        foreach ($landlords as $landlord) {
            $result[] = [
                'id' => $landlord['id'],
                'text' => $landlord['name'],
            ];
        }

        echo json_encode($result);
        exit();
    }

}