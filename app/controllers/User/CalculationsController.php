<?php

namespace app\controllers\User;

use app\controllers\AppController;
use app\models\Account;
use app\models\AppModel;
use app\models\Services;
use pronajem\libs\Pagination;
use RedBeanPHP\R;

class CalculationsController extends AppController {

    /**
     * Main page "Calculations"
     */
    public function indexAction(){

        if(!is_user_logged_in()){
            redirect('/user/login');
        }

        $userID = $_SESSION['user_id'];

        $this->setMeta('Vyúčtování', 'Seznam uložených vyúčtování');

        $this->layout = 'account';

        //set default calculation type
        $calcType = 'servicescalc';

        //set default order by
        $order = 'ORDER BY created_at DESC';

        //Get order by from GET
        if(isset($_GET['ordered'])){
            switch ($_GET['ordered']){
                case 'upd-up':
                $order = 'ORDER BY updated_at ASC';
                break;
                case 'upd-down':
                $order = 'ORDER BY updated_at DESC';
                break;
                case 'crt-up':
                $order = 'ORDER BY created_at ASC';
                break;
                case 'crt-down':
                $order = 'ORDER BY created_at DESC';
            }
        }


        //Get calculation type from $_GET
        if(isset($_GET['calc_type'])) {
            if(array_key_exists($_GET['calc_type'], Services::$calculationList)) {
                $calcType = $_GET['calc_type'];
            }
        }

        //variables for SQL conditions
        $condition = '';
        $params = [];

        //create Account model
        $accountModel = new Account();

        //create SQL conditions for filtr
        if($_GET) {
            $filterCond = $accountModel->filterQueryMaker($_GET, $calcType);
            $condition = $filterCond[0];
            $params = $filterCond[1];
        }
        array_unshift($params, $userID);

        //implement pagination
        $total = R::count($calcType, "user_id=? $condition", $params);
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perpage = 10;
        $pagination = new Pagination($page, $perpage, $total);
        $start = $pagination->getStart();


        //get calculation, including order, pagination and filter
        $calculations = R::findAll($calcType, "user_id=? $condition $order LIMIT $start, $perpage", $params);

        $calcURL = substr($calcType, 0, -4);
        $calcTypeValue = Services::getCalcValue($calcType);


        $this->set(compact('calculations', 'calcType', 'calcTypeValue', 'calcURL', 'pagination', 'total', 'accountModel'));

    }



    /**
     * Save calculation in DB like a new record
     * Working with ajax request from modal window "Save as..."
     * client code is located in ../calculations.js
     */
   public function savemodalAction() {
       if(!is_user_logged_in()){
           redirect('/user/login');
       }

       $userID = $_SESSION['user_id'];
       $response = null;


       if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
           //check if is it ajax and method POST
           if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SERVER['REQUEST_METHOD'] === 'POST'
               && !(empty($_POST['calculation_name'])) && !(empty($_POST['calculation_id']))) {

               //each calculation has uniq id number generated when calculation is created
               //id is available in calculation and sent here by JS
               $calcId = $_POST['calculation_id'];
               //calc type is available in calculation and sent here by JS
               $calcType = $_POST['calculation_type'];

               //initial data for every created calculation from form saved in session with uniq id
               if(isset($_SESSION[$calcType .'InitialData'][$calcId])){

                   foreach ($_SESSION[$calcType. 'InitialData'][$calcId] as $key => $value) {
                       //dont use values 'Ano' or 'Ne' form radio buttons
                       if(!empty($value) && $value !== 'Ano' && $value !== 'Ne') {

                           //every array is converting to string to save in DB
                           if (is_array($value)){
                               $value = "^" . implode("^", $value);
                           }

                           $data[$key] = $value;
                       }

                   }
                   $data['calculation_name'] = $_POST['calculation_name']; //entered by user
                   $data['calculation_description'] = $_POST['calculation_description']; //entered by user
                   $data['user_id'] = $userID;
                   $data['created_at'] = date('Y-m-d H:i:s');
                   $data['updated_at'] = date('Y-m-d H:i:s');

                   //save in DB and return record Id
                   $response = AppModel::dbSave($data, "${calcType}calc");

               }

               echo json_encode($response); //process invalid response!!
               die;
           }


       }


   }

    /**
     * Save calculation in DB with same id
     */
    public function saveAction() {
        if(!is_user_logged_in()){
            redirect('/user/login');
        }

        $userID  = $_SESSION['user_id'];
        $data = [];
        //if calculation was already saved to DB it has Id like DB record
        if($_GET['calculation_id'] && $_GET['calculation_type']){

            $calcType = $_GET['calculation_type'];

            //each calculation has uniq id number generated when calculation is created
            if(isset($_SESSION[$calcType . 'InitialData'][$_GET['id']])){

                foreach ($_SESSION[$calcType . 'InitialData'][$_GET['id']] as $key => $value) {
                    //dont use values 'Ano' or 'Ne' form radio buttons
                    if(!empty($value) && $value !== 'Ano' && $value !== 'Ne') {

                        //every array is converting to string before save to DB
                        if (is_array($value)){
                            $value = "^" . implode("^", $value);
                        }

                        $data[$key] = $value;
                    }

                }
                //$data['calctype'] = $_SESSION['costsResult'][$_GET['id']]['calcType'];
                //get id of existing DB record
                $data['id'] = $_GET['calculation_id'];
                $data['user_id'] = $userID;
                $data['updated_at'] = date('Y-m-d H:i:s');
                //$calcType = $_SESSION['costsResult'][$_GET['id']]['calcType'];

                $response = AppModel::dbSave($data, "${calcType}calc"); //process invalid response!!!

                redirect("/applications/${calcType}-calc?calculation_id=" . $data['id']);

            }
        }

    }

    public function ajaxdeleteAction(){

        if (!is_user_logged_in()) {
            redirect('/user/login');
        }
        $userID = $_SESSION['user_id'];

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
            if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SERVER['REQUEST_METHOD'] === 'POST'){

                if(!empty($_POST['recordId']) && !empty($_POST['table'])) {
                    $recordId = $_POST['recordId'];
                    $table = $_POST['table'];

                    $calculation = R::findOne($table, 'id=? AND user_id=?', [$recordId, $userID]);
                    if ($calculation) {
                        R::trash($calculation);
                        json_encode(true);
                        die();
                    }



                }
                json_encode(false);
                die();
            }

            redirect('/user/calculations');

        }

        redirect('/user/calculations');
       /* $calcType = 'servicescalc';

        if(isset($_GET['calc_type'])){
            if(array_key_exists($_GET['calc_type'], Services::$calculationList)) {
                $calcType = $_GET['calc_type'];
            }
        }

        if (isset($_GET['calculation_id'])) {
            $calculationID = $_GET['calculation_id'];
            $calculation = R::findOne($calcType, 'id=? AND user_id=?', [$calculationID, $userID]);
            if ($calculation) {

                R::trash($calculation);
                redirect("/user/calculations?calc_type={$calcType}");

            } else {
                $_SESSION['account_error'] = 'Nepodařilo se najít vyúčtování!';
                redirect('/user/error');
            }
        }else{

            redirect("/user/calculations?calc_type{$calcType}");

        }*/

    }



}