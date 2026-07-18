<?php

namespace app\controllers\Ajax;

use app\Models\Property;
use DI\Attribute\Inject;
use pronajem\base\Controller;

class PropertiesController extends Controller
{
    #[Inject]
    private Property $property;

    public function getList() : array
    {
        $userId = $_SESSION['user_id'];
        $term = $_GET['term']['term'] ?? '';

        if ($term === '') {
            echo json_encode([]);
            exit();
        }

        $properties = $this->property->getAllRecords(
            $term,
            ['address'],
            $userId,
            'ORDER BY address DESC'
        );

        $result = [];

        foreach ($properties as $property) {
            $result[] = [
                'id' => $property['id'],
                'text' => $property['address'],
            ];
        }

        echo json_encode($result);
        exit();
    }

}