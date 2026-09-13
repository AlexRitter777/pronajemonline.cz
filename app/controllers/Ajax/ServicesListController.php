<?php

namespace app\controllers\Ajax;

use app\Support\Services;
use DI\Attribute\Inject;
use pronajem\base\Controller;

class ServicesListController extends Controller
{

    #[Inject]
    private Services $services;


    public function getServicesList() : never
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

        echo json_encode($list);
        exit();

    }

}