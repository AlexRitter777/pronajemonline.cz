<?php

namespace app\controllers;

use app\models\Account;
use app\models\Applications;
use app\models\AppModel;
use pronajem\base\Controller;
use pronajem\libs\PdfCreator;

class AppController extends Controller {

    public function __construct($route)
    {
        parent::__construct($route);

        if (preg_match('#Edit$#', $route['action'])){
           $this->view = str_replace('edit', '', strtolower($route['action']));
       } else {
           $this->view = strtolower($route['action']);
       }

        new AppModel();
    }

    /**
     * @param $actionName
     *
     * Process calculation
     * Receive calculation name
     * Load data from DB or get from POST array
     * Run calculation, generate uniq id, save initial data and result data to session
     * Uses in ApplicationController actions
     *
     * @return array|void
     */
    protected function processCalculation(string $actionName){

        $data = [];

        //if we want to load calculation from DB, url has GET parametr id - record id in DB
        if(isset($_GET['calculation_id'])){

            if(!is_user_logged_in()){
                redirect('/user/login');
            }

            $calculationId = $_GET['calculation_id'];
            $userId = $_SESSION['user_id'];
            $account = new Account();
            $calc = $account->getCalculation($calculationId, "{$actionName}calc", $userId);
            if($calc) {
                $data = $account->prepareDataToCalculation($calc);
            }

        }
        //data came by POST in case of first calculation or in case of editing existing calculation
        if(!empty($_POST)) {

            $data = $_POST;
        }

        if($data){
            //debug($data);die();
            //make calculation
            $calculate = new Applications();
            $calculate->load($data);
            $calculationMethod =  $actionName . 'Calculation';
            $result = $calculate->$calculationMethod();
            $result['calcType'] = $actionName;

            //generate uniq id for each calculation for saving in session
            $result['id'] = time();

            //check if exist calculation name. It can exist if data once were loaded from DB
            //save calculation name to result array
            if (isset($data['calculationName'])) $result['calculationName'] = $data['calculationName'];

            //check if exist calculation id. It can exist if data once were loaded from DB
            //save calculation id to result array
            if (isset($data['id'])){
                $result['calculationId'] = $data['id'];
                //unset id in initial data for correct saving to DB with new id
                unset($data['id']);
            };

            if(!empty($data['updatedAt'])){
                $result['calculationDate'] = date( "d.m.Y", strtotime($data['updatedAt']));
            } elseif (!empty($data['createdAt'])){
                $result['calculationDate'] = date("d.m.Y", strtotime($data['createdAt']));
            } else {
                $result['calculationDate'] = date("d.m.Y");
            }


            $id = $result['id'];
            //Save initial data for calculation to session
            $_SESSION[$actionName . 'InitialData'][$id] = $data;
            //Save results of calculation to session - only for edit form, but we can also use initial data for editing
            $_SESSION[$actionName . 'Result'][$id] = $result;

            return $result;


        } else {
            header('Location: /');
            //throw new \Exception('Stranka není nalezená', 404);
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
                $formName = $account->getFormName();
                $recordId = $account->saveData($formName, $data, $userID);
                $newRecord = $account->getRecordById($recordId, $formName, $userID);
                $response["{$formName}ID"] = $recordId;
                $response["{$formName}Name"] = $newRecord->name;
                $response["{$formName}Address"] = $newRecord->address;
                if($newRecord->account) {
                    $response["{$formName}Account"] =  $newRecord->account;
                }

                echo json_encode($response);
                die;

            }

            redirect('/user/account');
        }

        redirect('/user/account');


    }


    /**
     * Create PDF - action
     * @throws \Exception
     */
    public function createpdfAction(){
        $calcType = '';
        if(!empty($_GET['calculation_type'])){
            $calcType = $_GET['calculation_type'];
        }

        if(!empty($_SESSION["{$calcType}Result"][$_GET['id']]) && !empty($calcType)) {

            $view = "applications/{$calcType}calc";
            $styles = file_get_contents("css/{$calcType}calc.css");
            $styles.= file_get_contents("css/calc.css");
            $result = $_SESSION["{$calcType}Result"][$_GET['id']];
            $data = compact('result');
            $fileName =  "Vyuctovani - {$calcType}calc.pdf";
            PdfCreator::pdfRender($data, $view, $styles, $fileName, 'D');
            die();
        }
        else {
            throw new \Exception('Stránka není nalezená', 404);
        }

    }

}

