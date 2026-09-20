<?php

namespace app\controllers\Ajax;

class MeterTypesController
{

    public function getMeterTypes()
    {
        $data = config('pronajemonline.meter_types');

        echo json_encode($data);
    }
}