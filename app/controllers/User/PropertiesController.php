<?php

namespace app\controllers\User;

use app\controllers\AppController;
use app\models\Account;
use Exception;
use RedBeanPHP\R;
use RedBeanPHP\RedException\SQL;

class PropertiesController extends AppController {

    public function indexAction(){

        if(!is_user_logged_in()){
            redirect('/user/login');
        }

        $userID = $_SESSION['user_id'];

        $this->setMeta('Nemovitosti', 'Seznam nemovitostí');

        $this->layout = 'account';

        $properties = R::findAll('property', 'user_id=?', [$userID]);

        $accountModel = new Account();

        $tenant = $accountModel->getPerson('tenant');

        //debug($tenant); die();

        $this->set(compact('properties', 'tenant'));

    }


    public function profileAction(){

        if(!is_user_logged_in()){
            redirect('/user/login');
        }

        $this->layout = 'account';

        $userID = $_SESSION['user_id'];

        if(isset($_GET['property_id'])){
            $property_id = $_GET['property_id'];
            $property = R::findOne('property', 'id=? AND user_id=?',[$property_id, $userID]);
            if ($property) {

                $accountModel = new Account();
                $tenant = $accountModel->getPerson('tenant');
                $landlord = $accountModel->getPerson('landlord');
                $admin = $accountModel->getPerson('admin');
                $elsupplier = $accountModel->getPerson('elsupplier');

                $this->setMeta('Karta nemovitosti', 'Profil pronajímátele');
                $this->set(compact('property', 'tenant', 'landlord', 'admin', 'elsupplier'));

            }else{

                $_SESSION['account_error'] = 'Nepodařilo se najít nemovitost!';
                redirect('/user/error');

            }

        }else {

            redirect('/user/properties');

        }

    }


    public function profileeditingAction(){

        if(!is_user_logged_in()){
            redirect('/user/login');
        }

        $this->layout = 'account_form';

        $userID = $_SESSION['user_id'];

        if(isset($_GET['property_id'])){
            $property_id = $_GET['property_id'];
            $property = R::findOne('property', 'id=? AND user_id=?',[$property_id, $userID]);
            if ($property) {
                $accountModel = new Account();
                $tenant = $accountModel->getPerson('tenant');
                $landlord = $accountModel->getPerson('landlord');
                $admin = $accountModel->getPerson('admin');
                $elsupplier = $accountModel->getPerson('elsupplier');

                $this->set(compact('property','tenant','landlord','admin', 'elsupplier'));
                $this->setMeta('Karta nemovitosti - editace', 'Karta nemovitosti');

            }else{
                $_SESSION['account_error'] = 'Nepodařilo se najít nemovitost!';
                redirect('/user/error');
            }

        } else {
            redirect('/user/properties');
        }

    }

    /**
     * Edit profile save
     *
     * @throws SQL
     * @throws Exception
     */
    public function profilesaveAction()
    {

        if (!is_user_logged_in()) {
            redirect('/user/login');
        }

        //$this->layout = 'account';

        $userID = $_SESSION['user_id'];

        if (isset($_GET['property_id'])) {

            $propertyID = $_GET['property_id'];

            if(!empty($_POST['property_address']) &&
                !empty($_POST['property_type']) &&
                isset($_POST['property_add_info']) &&
                isset($_POST['property_rent_payment']) &&
                isset($_POST['property_services_payment']) &&
                isset($_POST['property_electro_payment']) &&
                isset($_POST['property_contract_till'])){


                $property = R::findOne('property', 'id=? AND user_id=?',  [$propertyID, $userID] );
                if($property){

                    $property->address = $_POST['property_address'];
                    $property->type = $_POST['property_type'];
                    $property->add_info = $_POST['property_add_info'];
                    $property->landlord_id = !empty($_POST['property_landlord']) ? $_POST['property_landlord'] : null;
                    $property->tenant_id = !empty($_POST['property_tenant']) ? $_POST['property_tenant'] : null;
                    $property->admin_id = !empty($_POST['property_admin']) ? $_POST['property_admin'] : null;
                    $property->elsupplier_id = !empty($_POST['property_elsupplier']) ? $_POST['property_elsupplier'] : null;
                    $property->rent_payment = !empty($_POST['property_rent_payment']) ? $_POST['property_rent_payment'] : null;
                    $property->services_payment = !empty($_POST['property_services_payment']) ? $_POST['property_services_payment'] : null;
                    $property->electro_payment = !empty($_POST['property_electro_payment']) ? $_POST['property_electro_payment'] : null;
                    $property->contract_till = !empty($_POST['property_contract_till']) ? $_POST['property_contract_till'] : null;


                    if (!R::store($property)) throw new Exception('Chyba zápisu do DB!');

                    redirect("/user/properties/profile?property_id={$propertyID}");

                } else {
                    $_SESSION['account_error'] = 'Nepodařilo se najít nemovitost!';
                    redirect('/user/error');
                }

            }else{

                redirect('/user/properties');
            }

        } else {
           redirect('/user/properties');
        }

    }

    public function profiledeleteAction(){

        if (!is_user_logged_in()) {
            redirect('/user/login');
        }
        $userID = $_SESSION['user_id'];

        if (isset($_GET['property_id'])) {
            $propertyID = $_GET['property_id'];
            $property = R::findOne('property', 'id=? AND user_id=?', [$propertyID, $userID]);
            if ($property) {

                R::trash($property);
                redirect('/user/properties');

            } else {
                $_SESSION['account_error'] = 'Nepodařilo se najít nemovitost!';
                redirect('/user/error');
            }
        }else{

            redirect('/user/properties');

        }

    }


    public function addAction(){
        if(!is_user_logged_in()){
            redirect('/user/login');
        }

        $this->layout = 'account_form';

        $this->setMeta('Nová nemovitost', 'Založení nové nemovitosti');

    }


    /**
     * New property Save
     *
     * @throws SQL
     * @throws Exception
     */
    public function saveAction()
    {

        if (!is_user_logged_in()) {
            redirect('/user/login');
        }

        $userID = $_SESSION['user_id'];

        if(!empty($_POST['property_address']) &&
            !empty($_POST['property_type']) &&
            isset($_POST['property_add_info']) &&
            isset($_POST['property_rent_payment']) &&
            isset($_POST['property_services_payment']) &&
            isset($_POST['property_electro_payment']) &&
            isset($_POST['property_contract_till'])){

            if(!isset($_POST['property_landlord'])){$_POST['property_landlord'] = null;}
            if(!isset($_POST['property_tenant'])){$_POST['property_tenant'] = null;}
            if(!isset($_POST['property_admin'])){$_POST['property_admin'] = null;}
            if(!isset($_POST['property_elsupplier'])){$_POST['property_elsupplier'] = null;}

            $property = R::dispense('property');

            $property->address = $_POST['property_address'];
            $property->type = $_POST['property_type'];
            $property->add_info = $_POST['property_add_info'];
            $property->landlord_id = $_POST['property_landlord'];
            $property->tenant_id = $_POST['property_tenant'];
            $property->admin_id = $_POST['property_admin'];
            $property->elsupplier_id = $_POST['property_elsupplier'];
            $property->rent_payment = !empty($_POST['property_rent_payment']) ? $_POST['property_rent_payment'] : null;
            $property->services_payment = !empty($_POST['property_services_payment']) ? $_POST['property_services_payment'] : null;
            $property->electro_payment = !empty($_POST['property_electro_payment']) ? $_POST['property_electro_payment'] : null;
            $property->contract_till = !empty($_POST['property_contract_till']) ? $_POST['property_contract_till'] : null;
            $property->user_id = $userID;

            if (!($propertyID = R::store($property))) throw new Exception('Chyba zápisu do DB!');

            redirect("/user/properties/profile?property_id={$propertyID}");


        } else {

            redirect('/user/properties');

        }

    }

    public function savemodalAction(){

        if (!is_user_logged_in()) {
            redirect('/user/login');
        }

        $response = [];

        $userID = $_SESSION['user_id'];

        //check if it is an ajax request and data was sent in POST
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SERVER['REQUEST_METHOD'] === 'POST') {

                $data = $_POST;
                $account = new Account();
                $recordId = $account->saveData('property', $data, $userID);
                $newRecord = $account->getRecordById($recordId, 'property', $userID);
                $response["propertyID"] = $recordId;
                $response["propertyAddress"] = $newRecord->address;
                $response["propertyType"] = $newRecord->type;

                echo json_encode($response);
                die;

            }

            redirect('/user/account');
        }

        redirect('/user/account');


    }



}