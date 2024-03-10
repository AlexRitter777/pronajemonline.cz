<?php

namespace app\controllers;

use app\models\ReCaptcha;
use app\models\validation\Validation;

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
        $validate->load($data);
        $validate->validateContact();
        echo json_encode($validate->data);

        die();
    }

    public function registervalidationAction(){
        $data = $_POST;
        $validate = new Validation();
        $validate->load($data);
        $validate->validateRegister();
        echo json_encode($validate->data);

        die();

    }


    public function authorizationvalidationAction(){
        $data = $_POST;
        $validate = new Validation();
        $validate->load($data);
        $validate->validateAuthorization();
        echo json_encode($validate->data);

        die();

    }

    public function sendresetlinkvalidationAction(){
        $data = $_POST;
        $validate = new Validation();
        $validate->load($data);
        $validate->validateSendresetlink();
        echo json_encode($validate->data);

        die();

    }

    public function changepasswordvalidationAction(){
        $data = $_POST;
        $validate = new Validation();
        $validate->load($data);
        $validate->validateChangepassword();
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
                $validate->load($data);
                $validate->validateNewAndOldPassword();
                echo json_encode($validate->data);

            }

        }
        die();
    }



    public function modalnewtenantvalidationAction(){
        $data = $_POST;

        $data['landlord_name'] = $data['personName'];
        $data['landlord_address'] = $data['personAddress'];
        $data['landlord_email'] = $data['personEmail'];
        $data['landlord_phone_number'] = $data['personPhone'];
        $data['tenant_account'] = $data['personAccount'];

        $validate = new Validation();
        $validate->load($data);
        $validate->validateModalNewPerson();

        echo json_encode($validate->data);

        die();


    }

    public function modalnewlandlordvalidationAction(){

        $data = $_POST;
        $validate = new Validation();
        $validate->load($data);
        $validate->validateModalNewLandlord();

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
        $validate->load($data);
        $validate->validateProperty();
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