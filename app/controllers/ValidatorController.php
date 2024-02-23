<?php

namespace app\controllers;

use app\models\ReCaptcha;
use app\models\Validation;

class ValidatorController extends AppController {

    public function servicesvalidationAction() {

        $data = $_POST;
        $validate = new Validation();
        $validate->load($data);
        $validate->validateServices();
        echo json_encode($validate->data);


        die();

    }

    public function easyservicesvalidationAction() {

        $data = $_POST;
        $validate = new Validation();
        $validate->load($data);
        $validate->validateEasyServices();
        echo json_encode($validate->data);


        die();

    }


    public function electrovalidationAction() {

        $data = $_POST;
        $validate = new Validation();
        $validate->load($data);
        $validate->validateElectro();
        echo json_encode($validate->data);


        die();

    }

    public function depositvalidationAction() {

        $data = $_POST;
        $validate = new Validation();
        $validate->load($data);
        $validate->validateDeposit();
        echo json_encode($validate->data);


        die();

    }

    public function totalvalidationAction() {

        $data = $_POST;
        $validate = new Validation();
        $validate->load($data);
        $validate->validateTotal();
        echo json_encode($validate->data);


        die();

    }


    public function universalvalidationAction() {

        $data = $_POST;
        $validate = new Validation();
        $validate->load($data);
        $validate->validateUniversal();
        echo json_encode($validate->data);


        die();

    }

    public function contactvalidationAction(){
        $data = $_POST;
        $validate = new Validation();
        $validate->validateContact($data['contactName'], $data['contactEmail'], $data['contactMessage']);
        echo json_encode($validate->data);

        die();
    }

    public function registervalidationAction(){
        $data = $_POST;
        $validate = new Validation();
        $validate->validateRegister($data['userName'], $data['userEmail'], $data['userPassword'], $data['userPasswordRepeat']);
        echo json_encode($validate->data);

        die();

    }


    public function authorizationvalidationAction(){
        $data = $_POST;
        $validate = new Validation();
        $validate->validateAuthorization($data['userEmail'], $data['userPassword']);
        echo json_encode($validate->data);

        die();

    }

    public function sendresetlinkvalidationAction(){
        $data = $_POST;
        $validate = new Validation();
        $validate->validateSendresetlink($data['userEmail']);
        echo json_encode($validate->data);

        die();

    }

    public function changepasswordvalidationAction(){
        $data = $_POST;
        $validate = new Validation();
        $validate->validateChangepassword($data['userPassword'], $data['userPasswordRepeat']);
        echo json_encode($validate->data);

        die();

    }




    /**
     * Validate, if old and new passwords are not match
     */
    public function oldandnewpasswordsvalidationAction(){

        //check if is not direct url request
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            //check if is it ajax and method POST
            if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SERVER['REQUEST_METHOD'] === 'POST') {

                $data = $_POST;
                $validate = new Validation();
                $validate->validateNewAndOldPassword($data['userPasswordOld'], $data['userPasswordNew']);
                echo json_encode($validate->data);

            }

        }
        die();
    }



    public function modalnewtenantvalidationAction(){
        $data = $_POST;
        $validate = new Validation();

        $validate->validateModalNewPerson($data['tenant_name'], $data['tenant_address'], $data['tenant_email'], $data['tenant_phone_number'], $data['tenant_account']);

        echo json_encode($validate->data);

        die();


    }

    public function modalnewlandlordvalidationAction(){
        $data = $_POST;
        $validate = new Validation();

        $validate->validateModalNewPerson($data['landlord_name'], $data['landlord_address'], $data['landlord_email'], $data['landlord_phone_number'], $data['landlord_account']);

        echo json_encode($validate->data);

        die();

    }


    public function modalnewadminvalidationAction(){
        $data = $_POST;
        $validate = new Validation();
        $validate->load($data);
        $validate->validateModalNewAdmin();
        echo json_encode($validate->data);
        die();
    }

    public function propertyvalidationAction(){
        $data = $_POST;
        $validate = new Validation();

        $validate->validateProperty(
                    $data['propertyAddress'],
                    $data['propertyType'],
                    $data['propertyAddinfo'],
                    $data['propertyRentpayment'],
                    $data['propertyServicespayment'],
                    $data['propertyElectropayment']
        );

        echo json_encode($validate->data);

        die();

    }




    public function recaptchaAction(){
        $secretKey = "6LflMpQgAAAAAFo9XdCRLkMkO46ZWUKlzEtWU53R";
        $data = $_POST;
        if (isset($data['token'])) {
            $reCaptcha = new ReCaptcha();
            $reCaptcha->recaptchaValidate($data['token'], $secretKey);
            echo json_encode($reCaptcha->success);
            die();
        } else {
            throw new \Exception('Stranka není nalezená', 404);

        }


    }




}