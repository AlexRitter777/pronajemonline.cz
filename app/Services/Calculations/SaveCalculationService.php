<?php

declare(strict_types=1);

namespace app\Services\Calculations;


use app\Models\ServicesSettlement;
use DI\Attribute\Inject;

final class SaveCalculationService
{

    #[Inject]
    private readonly ServicesSettlement $servicescalc;

    public function saveCalculation(array $data, float $result, int $userId)
    {

        $prepared = $this->prepareData($data);

        $prepared['created_at'] = date('Y-m-d H:i:s');
        $prepared['updated_at'] = date('Y-m-d H:i:s');
        $prepared['result'] = $result;
        $prepared['user_id'] = $userId;

        return $this->servicescalc->saveAll($prepared);

    }

    private function prepareData(array $data)
    {
        foreach ($data as $key => $value) {
            if($value !== 'Ano' && $value !== 'Ne'){

                if (is_array($value)){
                    $value = "^" . implode("^", $value);
                }

                $data[$key] = $value;

            }
        }

        return $data;
    }

}