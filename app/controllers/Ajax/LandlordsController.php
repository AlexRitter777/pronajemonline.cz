<?php

namespace app\controllers\Ajax;

use app\actions\Landlord\CreateLandlordAction;
use app\Factories\LandlordDataFactory;
use app\Models\Landlord;
use DI\Attribute\Inject;
use pronajem\base\Controller;

class LandlordsController extends Controller
{

    #[Inject]
    private Landlord $landlord;

    #[Inject]
    private LandlordDataFactory $dataFactory;

    #[Inject]
    private CreateLandlordAction $action;


    public function getList() : never
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

    public function getOneRecord(int $landlordId) : never
    {
        $userId = $_SESSION['user_id'];

        $landlord = $this->landlord->getOneRecordById($landlordId, $userId);

        if (!$landlord) {
            throw new \Exception('Record not found.', 404);
        }

        echo json_encode($landlord);
        exit();

    }

    public function store() : never
    {
        $data = sanitize($_POST);
        $userId = $_SESSION['user_id'];
        $dto = $this->dataFactory->createFromArray($data);
        $landlordId = $this->action->execute($dto, $userId);

        echo json_encode([
            'landlordID' => $landlordId,
            'landlordName' => $dto->name,
            'landlordAddress' => $dto->address,
            'landlordAccount' => $dto->account,
        ]);
        exit();
    }


}