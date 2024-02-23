<?php

namespace app\controllers;

use app\models\Services;
use JetBrains\PhpStorm\NoReturn;
use pronajem\base\Controller;

class ServicesController extends AppController


{

    protected $servicesObject;


    public function __construct()
    {

        $this->servicesObject = new Services();
    }

    /*public function servicesAction(){

       $modelObject = new Services();
       $modelObject->getJsonList($modelObject->services);
       die();

    }*/

    public function servicesAction(){

        $this->servicesObject->getJsonList($this->servicesObject->services);
        die();

    }


    /*public function simplyservicesAction(){

        $modelObject = new Services();
        $modelObject->getSimplyList($modelObject->services);
        die();

    }*/

    public function simplyservicesAction(){

        $this->servicesObject->getSimplyList($this->servicesObject->services);
        die();

    }


    /*public function metersAction(){

        $modelObject = new Services();
        $modelObject->getJsonList($modelObject->meters);
        die();

    }*/
    public function metersAction(){

        $this->servicesObject->getJsonList($this->servicesObject->meters);
        die();

    }


    /*public function simplymetersAction(){

        $modelObject = new Services();
        $modelObject->getSimplyList($modelObject->meters);
        die();

    }*/

    public function simplymetersAction(){

        $this->servicesObject->getSimplyList($this->servicesObject->meters);
        die();

    }

    /*public function originsAction(){

        $modelObject = new Services();
        $modelObject->getJsonList($modelObject->origins);
        die();

    }*/

    public function originsAction(){

        $this->servicesObject->getJsonList($this->servicesObject->origins);
        die();

    }

    /*public function originselectroAction(){
        $modelObject = new Services();
        $modelObject->getJsonList($modelObject->originsElectro);
        die();
    }*/

    public function originselectroAction(){
        $this->servicesObject->getJsonList($this->servicesObject->originsElectro);
        die();
    }

    /*public function rentfinishreasonsAction(){

        $modelObject = new Services();
        $modelObject->getJsonList($modelObject->rentFinishReasons);
        die();

    }*/

    public function rentfinishreasonsAction(){

        $this->servicesObject->getJsonList($this->servicesObject->rentFinishReasons);
        die();

    }

    /*public function deposititemsAction(){

        $modelObject = new Services();
        $modelObject->getJsonList($modelObject->depositItems);
        die();

    }*/

    public function deposititemsAction(){

        $this->servicesObject->getJsonList($this->servicesObject->depositItems);
        die();

    }

    /*public function simplydeposititemsAction(){

        $modelObject = new Services();
        $modelObject->getSimplyList($modelObject->depositItems);
        die();

    }*/

    public function simplydeposititemsAction(){

        $this->servicesObject->getSimplyList($this->servicesObject->depositItems);
        die();

    }

    /*public function calculationtypeAction() {
        $modelObject = new Services();
        $modelObject->getJsonList($modelObject->calculationType);
        die();
    }*/

    public function calculationtypeAction() {
        $this->servicesObject->getJsonList($this->servicesObject->calculationType);
        die();
    }


    /*public function calculationyearAction() {
        $modelObject = new Services();
        $modelObject->getJsonList($modelObject->getYearsList());
        die();
    }*/

    public function calculationyearAction() {
        $this->servicesObject->getJsonList($this->servicesObject->getYearsList());
        die();
    }

    /*public function easyservicesAction(){

        $modelObject = new Services();
        $modelObject->getJsonList($modelObject->getServicesAndUtilites());
        die();

    }*/

    public function easyservicesAction(){

        $this->servicesObject->getJsonList($this->servicesObject->getServicesAndUtilites());
        die();

    }

    /*public function simplyeasyservicesAction(){

        $modelObject = new Services();
        $modelObject->getSimplyList($modelObject->getServicesAndUtilites());
        die();

    }*/

    public function simplyeasyservicesAction(){

        $this->servicesObject->getSimplyList($this->servicesObject->getServicesAndUtilites());
        die();

    }

    public function calculationlistAction(){
        echo json_encode(Services::$calculationList);
        die();

    }


}