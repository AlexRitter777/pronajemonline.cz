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

    public function getOneRecord(int $propertyId) : never
    {
        $userId = $_SESSION['user_id'];

        $property = $this->property->getOneRecordById($propertyId, $userId);

        if (!$property) {
            throw new \Exception('Record not found.', 404);
        }

        echo json_encode($property);
        exit();

    }

}