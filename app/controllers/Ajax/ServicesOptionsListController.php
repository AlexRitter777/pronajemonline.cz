<?php

namespace app\controllers\Ajax;

use app\Support\Services;
use DI\Attribute\Inject;

class ServicesOptionsListController
{

    #[Inject]
    private Services $services;

    public function getServicesOptionsList() : never
    {

        if(isset($_GET['form_type'])){
            $formType = $_GET['form_type'];;
        } else {
            $formType = 'servicescalc';
        }

        $list = match ($formType) {
            'easyservicescalc' => $this->services->getServicesAndUtilities(),
            'servicescalc', 'default' => $this->services->getServices()
        };



        $this->services->getSimplyList($list);
        exit();

    }

}