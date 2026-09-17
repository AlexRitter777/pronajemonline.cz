<?php

namespace app\controllers\Ajax;

class MeterTypesController
{

    public function getMeterTypes()
    {
        $data = require_once CONF . '/pronajemonline.php';

        echo json_encode($data['meter_types']);
    }
}