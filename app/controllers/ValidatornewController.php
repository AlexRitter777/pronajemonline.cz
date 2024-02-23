<?php

namespace app\controllers;

use app\models\Validation;
use app\models\Validationnew;
use app\models\ValidationRules;
use mysql_xdevapi\Exception;
use mysql_xdevapi\Result;

class ValidatornewController extends AppController
{

    /**
     * @throws \Exception
     */
    public function modalnewvalidationAction(){

        if (isset($_GET['formName']) && !empty($_GET['formName']) && (count($_POST) != 0)) {

            $formName = $_GET['formName'];
            $data = $_POST;
            $validationRules = ValidationRules::getValidationRules($formName);
            $validate = new Validationnew($data, $validationRules);
            $validationResult = $validate->validate();
            echo json_encode($validationResult);
            die();

        };

        throw new \Exception('All necessary data was not received from client side!', 500);

    }





}