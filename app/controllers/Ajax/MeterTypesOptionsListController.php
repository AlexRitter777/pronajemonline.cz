<?php

namespace app\controllers\Ajax;

use app\Support\Services;
use DI\Attribute\Inject;

class MeterTypesOptionsListController
{

    #[Inject]
    private Services $services;


    public function getMeterTypesOptionsList() : never
    {
        $data = config('pronajemonline.meter_types');
        $this->services->getSimplyList($data);
        exit();
    }


}